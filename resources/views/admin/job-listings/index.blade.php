@extends('layout.main')

@section('content')
    <h1>Job Listings</h1>
    
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Job Listings</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.job-listings.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="min_level" class="form-label">Minimum Qualification Level</label>
                    <select name="min_level" id="min_level" class="form-control">
                        <option value="">All Levels</option>
                        <option value="1" {{ $filters['min_level'] == '1' ? 'selected' : '' }}>Certificate</option>
                        <option value="2" {{ $filters['min_level'] == '2' ? 'selected' : '' }}>Diploma</option>
                        <option value="3" {{ $filters['min_level'] == '3' ? 'selected' : '' }}>Degree</option>
                        <option value="4" {{ $filters['min_level'] == '4' ? 'selected' : '' }}>Master</option>
                        <option value="5" {{ $filters['min_level'] == '5' ? 'selected' : '' }}>PhD</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="min_years_of_experience" class="form-label">Min Years Experience</label>
                    <input type="number" name="min_years_of_experience" id="min_years_of_experience" 
                           class="form-control" min="0" max="50" 
                           value="{{ $filters['min_years_of_experience'] ?? '' }}" 
                           placeholder="Any">
                </div>
                <div class="col-md-3">
                    <label for="is_published" class="form-label">Published Status</label>
                    <select name="is_published" id="is_published" class="form-control">
                        <option value="">All</option>
                        <option value="1" {{ $filters['is_published'] == '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ $filters['is_published'] == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('admin.job-listings.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <a href="{{ route('admin.job-listings.create') }}" class="btn btn-primary mb-3">Add New Job Listing</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Location</th>
                <th>Deadline</th>
                <th>Min Level</th>
                <th>Min Experience</th>
                <th>Applicants</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobListings as $jobListing)
                <tr>
                    <td>{{ $jobListing->title }}</td>
                    <td>{{ $jobListing->location }}</td>
                    <td>{{ $jobListing->deadline }}</td>
                    <td>
                        @if($jobListing->min_level)
                            @switch($jobListing->min_level)
                                @case(1) Certificate @break
                                @case(2) Diploma @break
                                @case(3) Degree @break
                                @case(4) Master @break
                                @case(5) PhD @break
                                @default Unknown
                            @endswitch
                        @else
                            <span class="text-muted">Any</span>
                        @endif
                    </td>
                    <td>
                        @if($jobListing->min_years_of_experience)
                            {{ $jobListing->min_years_of_experience }} years
                        @else
                            <span class="text-muted">Any</span>
                        @endif
                    </td>
                    <td>{{ $jobListing->applications?->count() ?? 0 }}</td>
                    <td>{{$jobListing->is_published == 1? 'Yes': 'No'}}</td>
                    <td>
                        <a href="{{ route('admin.job-listings.edit', $jobListing->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.applications.index', ['job_id' => $jobListing->id]) }}" class="btn btn-info btn-sm">View Applications</a>
                        <a href="{{ route('admin.applications.export', ['job_id' => $jobListing->id]) }}" class="btn btn-success btn-sm">Export Applicants</a>
                        <form action="{{ route('admin.job-listings.destroy', $jobListing->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job listing?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
