@extends('adminlte::page')

@section('title', 'All Jobs')

@section('content_header')
    <h1>All Posted Jobs</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Jobs List</h3>
        <div class="card-tools">
            @if(auth()->check() && auth()->user()->role == 'admin')
               <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary btn-sm">Post New Job</a>
            @endif
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Company Email</th>
                     <th>Location</th>
                     <th>salary</th>
                    <th>Category</th>
                    <th>description</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            @php
              if (!function_exists('formatSalary')) {
                  function formatSalary($amount) {
                      if ($amount >= 100000) {
                          return round($amount / 100000) . ' LPA';
                      } elseif ($amount >= 1000) {
                          return round($amount / 1000) . 'k';
                      }
                      return $amount;
                  }   
              }
            @endphp

            <tbody>
                @forelse($jobs as $key => $job)
                <tr>
                   <td>{{ $key + 1 }}</td>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->company_name }}</td>
                    <td>{{ $job->company_email }}</td>
                    <td>
                        {{ \Illuminate\Support\Str::limit($job->location, 10, '...') }}
                    </td>
                    <td>₹ {{ formatSalary($job->salary_min) }} - ₹{{ formatSalary($job->salary_max) }}</td>
                    <td>{{ $job->categoryData->name ?? 'N/A' }}</td>
                     <td>{!! \Illuminate\Support\Str::limit($job->description, 10, '...') !!}</td>
                    <td><span class="badge badge-info">{{ $job->job_type }}</span></td>
                    <td>
                        @if($job->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>

                        {{-- 🔹 ADMIN ACTIONS --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            
                            <a href="{{ url('/admin/jobs/edit/'.$job->id.'?from=jobs') }}" class="btn btn-smbtn btn-success">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('jobs.delete', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>   

                        @endif


                        {{-- 🔹 COMPANY JOB STATUS --}}
                        @if($job->posted_by_type == 'company')

                            @if($job->approval_status == 'pending')

                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-success" 
                                        href="{{ route('job.status', [$job->id, 'approved']) }}">
                                            Approve
                                        </a>
                                        <a class="dropdown-item text-danger" 
                                        href="{{ route('job.status', [$job->id, 'rejected']) }}">
                                            Reject
                                        </a>
                                    </div>
                                </div>

                            @elseif($job->approval_status == 'approved')

                                <span class="badge badge-success">Approved</span>

                            @elseif($job->approval_status == 'rejected')

                                <span class="badge badge-danger">Rejected</span>

                            @endif 

                        @endif 

                    </td>
                    <td>
                     @if(auth()->check() && auth()->user()->role == 'candidate')

                       <a href="{{ url('jobs/'.$job->id) }}"  class="btn btn-primary btn-sm">Apply Now  </a>

                     @endif
                     </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No jobs posted yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop