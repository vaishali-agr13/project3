


@extends('adminlte::page')
@section('title', 'My Profile')

@section('content')

@if(session('success'))
<div id="popup" class="popup">
    <div class="popup-content">
        <h3>✅ Your application submitted successfully</h3>
        <p>Please complete your profile</p>
        <p class="text-sm text-gray-600">Login details have been sent to your email ID successfully.</p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>
@endif



    <section class="content-header">
        <div class="container-fluid">
            <h1>My Profile</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color:red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>

                <form action="{{ route('candidate.profile.store') }}"  enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="card-body">


                       <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $profile->name ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $profile->phone ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="profile_photo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $profile->email ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label>Skills</label>
                            <input type="text" name="skills" class="form-control" value="{{ $profile->skills ?? '' }}" required>
                        </div>

                        <div class="form-group w-full block mb-4">
                            <label class="block mb-1 font-semibold text-gray-700">
                                Location
                            </label>

                            <div class="w-full">
                                <select name="location"
                                    class="w-full block px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Select Location</option>

                                    @foreach($cities as $city)
                                        <option value="{{ $city }}"
                                            {{ optional($profile)->location == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Experience</label>
                            <input type="text" name="experience" class="form-control" value="{{ $profile->experience ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label>Education</label>
                            <input type="text" name="education" class="form-control" value="{{ $profile->education ?? '' }}" required>
                        </div>

                         <div class="form-group">
                            <label>Upload Resume (PDF/DOC/DOCX)</label>

                                @if(!empty($profile->resume))
                                    <p>
                                        Current Resume: 
                                        <a href="{{ asset('storage/' . $profile->resume) }}" target="_blank">
                                            {{ basename($profile->resume) }}
                                        </a>
                                    </p>
                                @endif
                                <input type="hidden" name="old_resume" value="{{ $profile?->resume }}">
                                <input type="file" name="resume" class="form-control">
                        </div>

                         <div class="form-group">
                            <label>Portfolio</label>
                            <input type="text" name="portfolio" class="form-control" value="{{ $profile->portfolio ?? '' }}" required>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Profile</button>
                    </div>

                </form>
            </div>

        </div>
</section>


@endsection


@section('css')
<style>
.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none;
  justify-content: center;
  align-items: center;
  background: rgba(0,0,0,0.6);
  z-index: 99999;
}

.popup-content {
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  text-align: center;
}
</style>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let popup = document.getElementById('popup');

    if (popup) {
        popup.style.display = 'flex';
    }
});

function closePopup() {
    let popup = document.getElementById('popup');
    if (popup) {
        popup.style.display = 'none';
    }
}
</script>
@endsection
