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
                    Qualifications</a>
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
                <a href="{{ route('academic_records.create') }}" class="btn btn-primary mb-3">Add New</a>

                @if($records->isEmpty())
                    <p>No academic records found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Qualification </th>
                                <th>Course Name</th>
                                <th>Graduation Date</th>
                                <th>Institution Name</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>{{ $record->levelDescription() }}</td>
                                    <td>{{ $record->qualification_name }}</td>
                                    <td>
    {{ $record->graduation_date ? \Carbon\Carbon::parse($record->graduation_date)->format('d M Y') : 'N/A' }}
</td>

                                    <td>{{ $record->institution_name }}</td>
                                    <td>
                                        <a href="{{ route('files.academic_record.view', $record->id) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('files.academic_record.download', $record->id) }}" class="btn btn-success btn-sm">Download</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('academic_records.edit', $record->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('academic_records.destroy', $record->id) }}" method="POST"
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