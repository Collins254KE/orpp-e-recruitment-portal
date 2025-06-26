<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationSubmitted;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use ZipArchive;

class ApplicationsController extends Controller
{
    
  
   protected $qualificationRanks = [
        'Certificate' => 1,
        'Diploma'     => 2,
        'Degree'      => 3,
        'Master'      => 4,
        'PhD'         => 5,
    ];

    /**
     * Filter applications by minimum qualification, experience, completeness.
     */
    public function filter(Request $request)
    {
        $minQualification = ucfirst(strtolower(trim($request->input('min_qualification', 'Any'))));
        $minExperienceYears = (int) $request->input('min_experience_years', 0);
        $minCompleteness = (int) $request->input('min_completeness', 0);

        $minQualificationRank = $this->qualificationRanks[$minQualification] ?? 0;

        $applications = Application::with([
            'jobListing',
            'user.academicRecords',
            'user.employmentHistory',
            'user.professionalQualifications',
            'user.professionalMemberships',
            'user.referees',
        ])->get();

        $filtered = $applications->filter(function ($application) use (
            $minQualification,
            $minQualificationRank,
            $minExperienceYears,
            $minCompleteness
        ) {
            $user = $application->user;
            if (!$user) return false;

            if ($minQualification !== 'Any') {
                if ($user->academicRecords->isEmpty()) return false;

                $hasQualification = $user->academicRecords->contains(function ($record) use ($minQualificationRank) {
                    $qualification = strtolower(trim($record->qualification ?? ''));
                    foreach ($this->qualificationRanks as $key => $rank) {
                        if (str_contains($qualification, strtolower($key))) {
                            return $rank >= $minQualificationRank;
                        }
                    }
                    return false;
                });

                if (!$hasQualification) return false;
            }

            if ($minExperienceYears > 0) {
                $totalMonths = 0;
                foreach ($user->employmentHistory as $job) {
                    try {
                        $start = $job->start_date ? Carbon::parse($job->start_date) : null;
                        $end = $job->end_date ? Carbon::parse($job->end_date) : Carbon::now();
                        if ($start) {
                            $totalMonths += $end->diffInMonths($start);
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                if (($totalMonths / 12) < $minExperienceYears) return false;
            }

            if ($minCompleteness > 0 && method_exists($user, 'profileCompleteness')) {
                if ($user->profileCompleteness() < $minCompleteness) return false;
            }

            return true;
        });

        $page = $request->input('page', 1);
        $perPage = 10;

        $paginatedResults = new LengthAwarePaginator(
            $filtered->forPage($page, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.applications.index', ['applications' => $paginatedResults]);
    }

    /**
     * Show job listings and user's applications.
     */
    public function userApplications()
    {
        $jobListings = JobListing::isPublished()->paginate(10);
        $userApplications = Application::where('user_id', Auth::id())->pluck('job_listing_id')->toArray();

        return view('user.applications', compact('jobListings', 'userApplications'));
    }

    /**
     * Apply for a job - requires profile completeness and full biodata.
     */
    public function apply($id)
    {
        $user = Auth::user();
        $user->load([
            'academicRecords',
            'professionalQualifications',
            'professionalMemberships',
            'employmentHistory',
            'referees'
        ]);

        // Check required biodata fields
        $requiredBiodataFields = ['name', 'dob', 'phone', 'email', 'county', 'sub_county'];
        foreach ($requiredBiodataFields as $field) {
            if (empty($user->$field)) {
                return redirect()->back()->with('error', "Please complete your profile: missing {$field}.");
            }
        }

        if ($user->academicRecords->isEmpty()) {
            return redirect()->back()->with('error', 'Please add your academic qualifications.');
        }

        if ($user->professionalQualifications->isEmpty()) {
            return redirect()->back()->with('error', 'Please add your professional qualifications.');
        }

        if ($user->professionalMemberships->isEmpty()) {
            return redirect()->back()->with('error', 'Please add your professional memberships.');
        }

        if ($user->employmentHistory->isEmpty()) {
            return redirect()->back()->with('error', 'Please add your employment history.');
        }

        if ($user->referees->isEmpty()) {
            return redirect()->back()->with('error', 'Please add your referees.');
        }
if (!$user->isProfileComplete()) {
    return redirect()->back()->with('error', 'Please complete your profile before applying.');
}


        // Check if already applied
        if (Application::where('user_id', $user->id)->where('job_listing_id', $id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

       $application = Application::create([
    'job_listing_id' => $id,
    'user_id'        => $user->id,
    'status'         => 'Processing',
]);

Mail::to($user->email)->queue(new ApplicationSubmitted($user, $application));



        return redirect()->route('user.applications')->with('success', 'Application submitted successfully.');
    }

    /**
     * Show job detail page.
     */
    public function show($id)
    {
        $jobDetail = JobListing::findOrFail($id);
        $hasApplied = Application::where('user_id', Auth::id())->where('job_listing_id', $id)->exists();

        return view('user.job_detail', ['job_detail' => $jobDetail, 'hasApplied' => $hasApplied]);
    }

    /**
     * Update application status (admin).
     */
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        $application = Application::findOrFail($id);
        $application->update(['status' => $request->input('status')]);

        return redirect()->back()->with('success', 'Application status updated.');
    }

    /**
     * Show a user's application detail.
     */
    public function showApplication($id)
    {
        $application = Application::with('jobListing')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.application_detail', compact('application'));
    }

    /**
     * View uploaded document for an application.
     */
    public function viewDocument($id)
{
    $application = Application::findOrFail($id);

    if (!$application->document_filename) {
        abort(404, 'No document uploaded.');
    }

    $filePath = storage_path('app/public/documents/' . $application->document_filename);

    if (!file_exists($filePath)) {
        abort(404, 'Document not found.');
    }

    return response()->file($filePath);
}

   
    /**
     * Upload document for an application.
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'application_id' => 'required|exists:applications,id',
        ]);

        $filename = time() . '_' . $request->file('document')->getClientOriginalName();
        $request->file('document')->storeAs('documents', $filename, 'public');

        $application = Application::find($request->application_id);
        $application->update(['document_filename' => $filename]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    /**
     * Export applicants CSV with profile completeness.
     */
    public function exportApplicants($job_id)
    {
        $applications = Application::where('job_listing_id', $job_id)
            ->with([
                'user',
                'user.academicRecords',
                'user.professionalQualifications',
                'user.professionalMemberships',
                'user.employmentHistory',
                'user.referees',
            ])->get();

        $fileName = 'applicants_job_' . $job_id . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $columns = [
            'Name', 'Email', 'Phone', 'County', 'Sub County', 'Ethnicity', 'DOB', 'Gender',
            'Nationality', 'ID/Passport', 'KRA Pin',
            'Academic Records', 'Professional Qualifications', 'Professional Memberships',
            'Work History', 'Referees', 'Profile Completeness'
        ];

        $callback = function () use ($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($applications as $app) {
                $user = $app->user;
                if (!$user) continue;

                $academicRecords = $user->academicRecords->map(fn($r) => "{$r->qualification} ({$r->institution}, {$r->year_completed})")->implode('; ');
                $profQualifications = $user->professionalQualifications->map(fn($q) => "{$q->qualification} ({$q->institution}, {$q->year_completed})")->implode('; ');
                $profMemberships = $user->professionalMemberships->map(fn($m) => "{$m->organization} ({$m->membership_number})")->implode('; ');
                $workHistory = $user->employmentHistory->map(function ($job) {
                    $start = !empty($job->start_date) ? Carbon::parse($job->start_date)->format('Y-m') : 'N/A';

                    $end = $job->end_date ? Carbon::parse($job->end_date)->format('Y-m') : 'Present';
                    return "{$job->position} at {$job->company} ({$start} - {$end})";
                })->implode('; ');
                $referees = $user->referees->map(fn($r) => trim("{$r->first_name} {$r->middle_name} {$r->other_name}") . " ({$r->referee_type}, {$r->email})")->implode('; ');

                $completeness = method_exists($user, 'profileCompleteness') ? $user->profileCompleteness() . '%' : 'N/A';

                fputcsv($file, [
                    $user->name ?? '', $user->email ?? '', $user->phone ?? '',
                    $user->county ?? '', $user->sub_county ?? '', $user->ethnicity ?? '',
                    $user->dob ? Carbon::parse($user->dob)->format('Y-m-d') : '', $user->gender ?? '',
                    $user->nationality ?? '', $user->id_passport ?? '', $user->kra_pin ?? '',
                    $academicRecords, $profQualifications, $profMemberships, $workHistory, $referees,
                    $completeness
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download ZIP of all applicant documents for a job.
     */
    public function downloadAllDocuments($job_id)
    {
        $applications = Application::with('user')
            ->where('job_listing_id', $job_id)
            ->get();

        $zipFileName = 'applicants_documents_job_' . $job_id . '_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($applications as $application) {
                $user = $application->user;
                if (!$user || !$application->document_filename) continue;

                $filePath = storage_path('app/public/documents/' . $application->document_filename);
                if (file_exists($filePath)) {
                    $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $user->name ?? 'applicant');
                    $zip->addFile($filePath, "{$safeName}_{$application->id}_" . $application->document_filename);
                }
            }
            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return redirect()->back()->with('error', 'Could not create ZIP file.');
    }
}
