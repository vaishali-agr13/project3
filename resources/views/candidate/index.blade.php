@extends('adminlte::page')

@section('title', 'Candidates')

@section('content_header')
    <h1>Registered Candidates</h1>
@stop

@section('content')

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">Candidate List</h3>
    </div>

    <div class="card-body p-0">


        <div class="card-header">

            <form method="GET" action="{{ url()->current() }}">
                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-3">
                        <input type="text"
                            name="name"
                            class="form-control"
                            placeholder="Search by name"
                            value="{{ request('name') }}">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-3">
                        <input type="text"
                            name="email"
                            class="form-control"
                            placeholder="Search by email"
                            value="{{ request('email') }}">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-3">
                        <input type="text"
                            name="phone"
                            class="form-control"
                            placeholder="Search by phone"
                            value="{{ request('phone') }}">
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-3 d-flex">
                        <button type="submit" class="btn btn-primary mr-2">
                            Filter
                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <table class="table table-hover table-striped mb-0">
            
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Skills</th>
                    <th>Experience</th>
                    <th>Location</th>
                    <th>Education</th>
                    <th>Resume</th>
                    <th>Registered On</th>
                </tr>
            </thead>

            <tbody>
                @forelse($candidates as $key => $candidate)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $candidate->name }}</strong></td>
                        <td>{{ $candidate->email }}</td>
                        <td>{{ $candidate->candidateProfile->phone ?? 'N/A' }}</td>
                        <td>{{ $candidate->candidateProfile->skills ?? 'N/A' }}</td>
                        <td>{{ $candidate->candidateProfile->experience ?? 'N/A' }}</td>
                        <td>{{ $candidate->candidateProfile->location ?? 'N/A' }}</td>
                        <td>{{ $candidate->candidateProfile->education ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . optional($candidate->candidateProfile)->resume) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-file-pdf"></i> View Resume
                            </a>
                        </td>
                        </td>
                        <td>
                            {{ optional($candidate->created_at)->format('d M Y') ?? 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No candidates found
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@stop