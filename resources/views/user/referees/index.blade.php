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
                <a href="{{ route('referees.create') }}" class="btn btn-primary mb-3">Add New</a>


                @if($referees->isEmpty())
                    <p>No referees found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Other Name</th>
                                <th>Organization</th>
                                <th>Designation</th>
                                <th>Referee Type</th>
                                <th>Email</th>
                                <th>Mobile Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referees as $referee)
                                <tr>
                                    <td>{{ $referee->first_name }}</td>
                                    <td>{{ $referee->middle_name }}</td>
                                    <td>{{ $referee->other_name }}</td>
                                    <td>{{ $referee->organization }}</td>
                                    <td>{{ $referee->designation }}</td>
                                    <td>{{ ucfirst($referee->referee_type) }}</td>
                                    <td>{{ $referee->email }}</td>
                                    <td>{{ $referee->mobile_phone }}</td>
                                  <td>
            <a href="{{ route('referees.edit', $referee->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('referees.destroy', $referee->id) }}" method="POST" style="display:inline;">
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