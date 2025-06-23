<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\JobListing;
class ApplicationController extends Controller
{
    //admin should be able to see all applications
    public function index(Request $request){
        // get all applications by job listing id
        $applications = Application::when($request->job_id, function($query, $job_id){
            return $query->where('job_listing_id', $job_id);
        })->get();
        return view('admin.applications.index', compact('applications'));
    }

    //admin should be able to see all applications for a specific job listing
    public function show($id){
        $application = Application::find($id);
        return view('admin.applications.show', compact('application'));
    }
    // admin should be able to update the status of an application
    public function update(Request $request, $id){
        $application = Application::find($id);
        $application->status = $request->status;
        $application->save();
        return redirect()->route('admin.applications.index');
    }
    
    
}
