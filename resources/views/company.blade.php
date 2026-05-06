@extends('layouts.app')

@section('content')

<div class="bg-gray-100 min-h-screen py-10">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-wrap lg:flex-nowrap gap-6">

      <!-- LEFT SIDE (Company Info) -->
      <div class="w-full lg:w-1/2">
        <div class="bg-white p-8 rounded-xl shadow-sm">
          <h2 class="text-2xl font-bold mb-4 text-gray-900">About Our Company</h2>
          <p class="text-gray-600 mb-6">
            We are a growing platform helping companies post jobs and hire the best talent.
          </p>

          <h3 class="text-lg font-semibold text-gray-800 mb-2">Terms & Conditions</h3>
          <ul class="list-disc pl-5 text-gray-600 space-y-2 mb-6">
            <li>You can post maximum 10 jobs per month.</li>
            <li>All job posts must be genuine and verified.</li>
            <li>Spam or duplicate jobs will be removed.</li>
          </ul>

          <h3 class="text-lg font-semibold text-gray-800 mb-2">Privacy Policy</h3>
          <p class="text-gray-600">
            Your company information and job details are safe and will not be shared with third parties.
          </p>
        </div>
      </div>

      <!-- RIGHT SIDE (Job Form) -->
      <div class="w-full lg:w-1/2">
        <div class="bg-white p-8 rounded-xl shadow-md border-t-4 custom-border">
          <h2 class="text-2xl font-bold mb-6 text-gray-900">Post a Job</h2>

          
          @if(session('success'))
              <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                  {{ session('success') }}
              </div>
          @endif

          <form action="/jobs/store" method="POST" class="space-y-4">
            @csrf

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
              <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg" placeholder="Software Developer" required>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Company Name</label>
              <input type="text" name="company_name" class="w-full px-4 py-2 border rounded-lg" placeholder="ABC Pvt Ltd" required>
            </div>
            
              <div class="card card-primary">
                  <div class="card-body">

                      <div class="form-group">
                          <label class="font-weight-bold">Category</label>

                          <select name="category" class="form-control" required>
                              <option value="">-- Select Category --</option>

                              @foreach($categories as $cat)
                                  <option value="{{ $cat->id }}">
                                      {{ $cat->name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                  </div>
              </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Company Email</label>
              <input type="email" name="company_email" class="w-full px-4 py-2 border rounded-lg" placeholder="info@domain.com" required>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
              <input type="text" name="location" class="w-full px-4 py-2 border rounded-lg" placeholder="Indore" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Min Salary</label>
                <input type="text" name="salary_min" class="w-full px-4 py-2 border rounded-lg" placeholder="3-6 LPA" required>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Max Salary</label>
                <input type="text" name="salary_max" class="w-full px-4 py-2 border rounded-lg" placeholder="3-6 LPA" required>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Who can apply</label>
                <input type="text" name="who_can_apply" class="w-full px-4 py-2 border rounded-lg" placeholder="who can apply" required>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">No Of Openings</label>
                <input type="text" name="no_of_openings" class="w-full px-4 py-2 border rounded-lg" placeholder="No of Openings" required>
              </div>

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Roles & Responsibility</label>
                <input type="text" name="roles_responsibility" class="w-full px-4 py-2 border rounded-lg" placeholder="Roles & Responsibility" required>
              </div>

               <div class="col-span-2">
                  <label class="block text-sm font-semibold text-gray-700 mb-1">
                      Skills Required
                  </label>
                  <input type="text" name="skills_required" class="w-full px-4 py-2 border rounded-lg" placeholder="No of Openings" required>


                  <!-- <div class="border rounded-lg p-3 bg-gray-50">
                      <div class="grid grid-cols-2 md:grid-cols-3 gap-2">

                          <label class="flex items-center space-x-2">
                              <input type="checkbox" name="skills_required[]" value="php" class="accent-purple-700">
                              <span>PHP</span>
                          </label>

                          <label class="flex items-center space-x-2">
                              <input type="checkbox" name="skills_required[]" value="laravel" class="accent-purple-700">
                              <span>Laravel</span>
                          </label>

                          <label class="flex items-center space-x-2">
                              <input type="checkbox" name="skills_required[]" value="mysql" class="accent-purple-700">
                              <span>MySQL</span>
                          </label>

                          <label class="flex items-center space-x-2">
                              <input type="checkbox" name="skills_required[]" value="javascript" class="accent-purple-700">
                              <span>JavaScript</span>
                          </label>

                          <label class="flex items-center space-x-2">
                              <input type="checkbox" name="skills_required[]" value="vue" class="accent-purple-700">
                              <span>Vue.js</span>
                          </label>

                      </div>
                  </div> -->
              </div>
              

              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Job Type</label>
                <select name="job_type" class="w-full px-4 py-2 border rounded-lg" required>
                      <option value="Full-time">Full-time</option>
                      <option value="Part-time">Part-time</option>
                      <option value="Contract">Contract</option>
                      <option value="Remote">Remote</option>
                </select>
              </div>

               <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Experience Required</label>
                <input type="text" name="experience" class="w-full px-4 py-2 border rounded-lg" placeholder="2-3 years" required>

              </div>

              <input type="hidden" name="posted_by_type" value="company">
              
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-1">Job Description</label>
              <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg" required></textarea>
            </div>

            <button type="submit" class="w-full bg-lime-600  text-white py-3 rounded-lg font-bold transition">
               Post Job
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

  <script>
    setTimeout(() => {
        let msg = document.querySelector('.alert, .bg-green-100');
        if (msg) msg.style.display = 'none';
    }, 3000);
</script>
