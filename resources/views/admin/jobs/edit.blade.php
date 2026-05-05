@extends('adminlte::page')

@section('title', 'Edit Job')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Edit Job</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('jobs.update', $job->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="title" class="form-control" value="{{ $job->title }}">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $job->category == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company_name" class="form-control" value="{{ $job->company_name }}">
            </div>

            <div class="form-group">
                <label>Company Email</label>
                <input type="text" name="company_email" class="form-control" value="{{ $job->company_email }}">
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ $job->location }}">
            </div>

           <div class="form-group">
                <label>Roles & Responsibility</label>
                <input type="text" name="roles_responsibility" class="form-control" value="{{ $job->roles_responsibility }}">
            </div>

             <div class="form-group">
                <label>No Of Openings</label>
                <input type="text" name="no_of_openings" class="form-control" value="{{ $job->no_of_openings }}">
            </div>

            <div class="form-group">
                <label>Who Can Apply</label>
                <input type="text" name="who_can_apply" class="form-control" value="{{ $job->who_can_apply }}">
            </div>


            <!-- @php
                $selectedSkills = old('skills_required', is_array($job->skills_required) 
                    ? $job->skills_required 
                    : json_decode($job->skills_required, true));
            @endphp -->
           <div class="form-group">
                <label>Skills Required</label>              
                 <input type="text" name="skills_required" class="form-control" value="{{ $job->skills_required }}">


                <!-- <select name="skills_required[]" multiple class="form-control">
                    <option value="php" {{ in_array('php', $selectedSkills ?? []) ? 'selected' : '' }}>PHP</option>
                    <option value="laravel" {{ in_array('laravel', $selectedSkills ?? []) ? 'selected' : '' }}>Laravel</option>
                    <option value="mysql" {{ in_array('mysql', $selectedSkills ?? []) ? 'selected' : '' }}>MySQL</option>
                    <option value="javascript" {{ in_array('javascript', $selectedSkills ?? []) ? 'selected' : '' }}>JavaScript</option>
                    <option value="vue" {{ in_array('vue', $selectedSkills ?? []) ? 'selected' : '' }}>Vue.js</option>
                </select> -->
            </div>
            
            <div class="form-group">
                <label>Min Salary</label>
                <input type="text" name="salary_min" class="form-control" value="{{ $job->salary_min }}">
            </div>

            <div class="form-group">
                <label>Max Salary</label>
                <input type="text" name="salary_max" class="form-control" value="{{ $job->salary_max }}">
            </div>

            <div class="form-group">
                <label>Experience</label>
                <input type="text" name="experience" class="form-control" value="{{ $job->experience }}">
            </div>

            <div class="form-group">
                <label>Job Type</label>
                <select name="job_type" class="form-control">
                    <option {{ $job->job_type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option {{ $job->job_type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{!! $job->description !!}</textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $job->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $job->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <input type="hidden" name="posted_by_type" value="admin">
            <input type="hidden" name="from" value="{{ $from }}">

            <button class="btn btn-primary mt-3">Update Job</button>
        </form>
    </div>
</div>

@endsection 