@extends('layout.main')

@section('content')
    <div class="container">
        <h1>User Profile</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" id="biodata-tab"
                    href="{{ route('profile') }}" role="tab">Biodata</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('academic_records.index') ? 'active' : '' }}" id="academic-tab"
                    href="{{ route('academic_records.index') }}" role="tab">Academic
                    Records</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('professional_qualifications.index') ? 'active' : '' }}"
                    id="qualifications-tab" href="{{ route('professional_qualifications.index') }}" role="tab">Professional
                    Qualifications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('professional_memberships.index') ? 'active' : '' }}"
                    id="bodies-tab" href="{{ route('professional_memberships.index') }}" role="tab">Professional Bodies</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('employment_history.index') ? 'active' : '' }}" id="employment-tab"
                    href="{{ route('employment_history.index') }}" role="tab">Work Experience</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('referees.index') ? 'active' : '' }}" id="referees-tab"
                    href="{{ route('referees.index') }}" role="tab">Referees</a>
            </li>
        </ul>

        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('employment_history.create') }}" class="btn btn-primary mb-3">Add New</a>


                @if($employmentHistories->isEmpty())
                    <p>No employment history found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Employer Name</th>
                                <th>Job Position</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Roles & Responsibilities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employmentHistories as $history)
                                <tr>
                                    <td>{{ $history->employer_name }}</td>
                                    <td>{{ $history->job_position }}</td>
     <td>
    {{ $history->date_joined ? \Carbon\Carbon::parse($history->date_joined)->format('d M Y') : 'N/A' }}
</td>

                                    
                                    <td>
    {{ $history->date_left ? \Carbon\Carbon::parse($history->date_left)->format('d M Y') : 'Current' }}
</td>
                                    <td>{{ strip_tags($history->roles_responsibilities) }}</td>

                                    <td>
                                        <a href="{{ route('employment_history.edit', $history->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('employment_history.destroy', $history->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection