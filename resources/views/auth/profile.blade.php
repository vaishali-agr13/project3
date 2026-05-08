@extends('adminlte::page')

@section('title', 'Create Profile')

@section('content_header')
    <h1>Create Profile</h1>
@stop

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $profile ? 'Edit Profile' : 'Create Profile' }}
                    </h3>
                </div>

                <form action="{{ $profile ? route('profile.update', $profile->id) : route('profile.store') }}" method="POST">
                    @csrf

                    @if($profile)
                        @method('PUT')
                    @endif

                    <div class="card-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text"
                                   required
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Name"
                                   value="{{ old('name', $profile->name ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email"
                                  required
                                   name="email"
                                   class="form-control"
                                   placeholder="Enter Email"
                                   value="{{ old('email', $profile->email ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text"
                                   name="phone"
                                   required
                                   class="form-control"
                                   placeholder="Enter Phone"
                                   value="{{ old('phone', $profile->phone ?? '') }}">
                        </div>


                        <div class="form-group">
                                <label>Logo</label>

                                <input type="file" name="logo" class="form-control">

                                @if($profile && $profile->logo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/profiles/'.$profile->logo) }}"
                                            width="80"
                                            height="80"
                                            required
                                            style="object-fit: cover; border-radius: 10px;">
                                    </div>
                                @endif
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            {{ $profile ? 'Update Profile' : 'Save Profile' }}
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary float-right">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@stop