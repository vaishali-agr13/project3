@extends('adminlte::page')

@section('title', 'Job Applications')

@section('content_header')
    <h1>Applied Jobs</h1>
@stop

@section('content')

        @if(auth()->check() && auth()->user()->role === 'admin')

                <form method="GET" action="{{ url()->current() }}" class="mb-3">
                    <div class="row">

                        {{-- 🔍 Title Search --}}
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control"
                                placeholder="Search by job title"
                                value="{{ request('title') }}">
                        </div>

                        {{-- 📅 Date Search --}}
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control"
                                value="{{ request('date') }}">
                        </div>

                        {{-- 👤 Name Search --}}
                            <div class="col-md-4 mt-2">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Search by name"
                                    value="{{ request('name') }}">
                            </div>

                            {{-- 📱 Mobile Search --}}
                            <div class="col-md-4 mt-2">
                                <input type="text" name="mobile" class="form-control"
                                    placeholder="Search by mobile number"
                                    value="{{ request('mobile') }}">
                            </div>

                        {{-- 🔘 Buttons --}}
                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                Filter
                            </button>

                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('applications.export', request()->all()) }}" 
                    class="btn btn-danger">
                        Export PDF
                    </a>
                </div>

        @endif


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Candidates List</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Candidate Name</th>
                    <th>Applied For</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Resume</th>
                    <th>Date</th>
                    <th>status</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $key => $app)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><b>{{ $app->full_name }}</b></td>
                    <td><span class="badge badge-info">{{ $app->job->title ?? 'N/A' }}</span></td>
                    <td>{{ $app->email }}</td>
                    <td>
                       <a href="https://wa.me/91{{ $app->phone }}" target="_blank">Chat on WhatsApp</a>
                    </td>
                    <td>
                        <a href="{{ asset('storage/' . $app->resume) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-file-pdf"></i> View Resume
                        </a>
                    </td>
                    <td>{{ $app->created_at->format('d M, Y') }}</td>

                    <td>
                        @if($app->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($app->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                        <td>

                        <!-- View Button -->
                        <button class="btn btn-sm btn-primary mb-1"
                            data-toggle="modal" data-target="#modal-{{ $app->id }}">
                            View
                        </button>

                        @if(auth()->user()->role === 'admin')

                            @if($app->status == 'pending')

                                <div class="d-flex gap-2 mt-1">

                                    {{-- Approve --}}
                                    <form action="{{ route('applications.updateStatus', $app->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Approve this application?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <form action="{{ route('applications.updateStatus', $app->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Reject this application?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>

                                </div>

                            @else
                                <span class="badge badge-secondary">Action Done</span>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('applications.delete', $app->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');"
                                class="mt-1">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>

                        @endif

                        </td>
                                            
                        
                    

                </tr>



                {{-- Modal for Cover Letter --}}
               <div class="modal fade" id="modal-{{ $app->id }}">
    <div class="modal-dialog modal-lg">  {{-- 🔥 large modal --}}
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-briefcase"></i> Job Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- BODY -->
                            <div class="modal-body">

                                <!-- JOB TITLE -->
                                <h4 class="text-primary mb-3">
                                    {{ $app->job->title ?? 'N/A' }}
                                </h4>

                                <!-- COMPANY + LOCATION -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>🏢 Company:</strong> {{ $app->job->company_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>📍 Location:</strong> 
                                        
                                         {{ \Illuminate\Support\Str::limit($app->job->location , 10, '...') }}                                    
                                    </p>
                                    </div>
                                </div>

                                <!-- SALARY + TYPE -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>💰 Salary:</strong> ₹{{ $app->job->salary_min ?? '' }} - ₹{{ $app->job->salary_max ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>⏳ Job Type:</strong> {{ $app->job->job_type ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <hr>

                                <!-- DESCRIPTION -->
                                <h6><strong>📝 Job Description:</strong></h6>
                                <p style="white-space: pre-line;">
                                    {!! $app->job->description ?? 'No description available.' !!}
                                </p>

                                <hr>

                                <!-- COVER LETTER -->
                                <h6><strong>📩 Your Cover Letter:</strong></h6>
                                <p class="bg-light p-2 rounded">
                                    {{ $app->cover_letter ?? 'No cover letter provided.' }}
                                </p>

                            </div>

                            <!-- FOOTER -->
                        

                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="7" class="text-center">No applications received yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop