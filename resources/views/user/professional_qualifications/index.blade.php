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
                    id="bodies-tab" href="{{ route('professional_memberships.index') }}" role="tab">Professional Membership</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('employment_history.index') ? 'active' : '' }}" id="employment-tab"
                    href="{{ route('employment_history.index') }}" role="tab">Employment
                    History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs('referees.index') ? 'active' : '' }}" id="referees-tab"
                    href="{{ route('referees.index') }}" role="tab">Referees</a>
            </li>
        </ul>

        <div class="card mb-4">
            <div class="card-body">
                <a href="{{ route('professional_qualifications.create') }}" class="btn btn-primary mb-3">Add New</a>


                @if($qualifications->isEmpty())
                    <p>No professional qualifications found.</p>
                @else
                    <table class="table">
                        <thead>
    <tr>
        <th>Level</th>
        <th>Description</th>
        <th>File</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>


<tbody>
    @foreach($qualifications as $qualification)
        <tr>
            <td>{{ $qualification->levelDescription() }}</td>
            <td>{{ $qualification->description }}</td>
            <td>
                <a href="{{ route('files.professional_qualification.view', $qualification->id) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('files.professional_qualification.download', $qualification->id) }}" class="btn btn-success btn-sm">Download</a>
            </td>
          

<td>
    <a href="{{ route('professional_qualifications.edit', $qualification->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

    <form action="{{ route('professional_qualifications.destroy', $qualification->id) }}"
          method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this qualification?')">
            Delete
        </button>
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