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

    <div class="w-full lg:w-1/2 mx-auto">

    <!-- STEP 1 : COMPANY DETAILS -->
    <div id="step1" class="{{ session('step') == 2 ? 'hidden' : '' }} bg-white p-8 rounded-xl shadow-md border-t-4 custom-border">

        <h2 class="text-2xl font-bold mb-6 text-gray-900">
            Company Details
        </h2>

         @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="/company/store" method="POST">
          @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Company Name
                    </label>

                    <input type="text"
                        name="company_name"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="ABC Pvt Ltd" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Company Email
                    </label>

                    <input type="email"
                        name="company_email"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="info@company.com" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Phone Number
                    </label>

                    <input type="text"
                        name="company_phone"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="+91 9876543210" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Website
                    </label>

                    <input type="text"
                        name="website"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="www.company.com">
                </div>

                

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Pincode
                    </label>

                    <input type="text"
                        name="pincode"
                        id="pincode"
                         maxlength="6"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="452001" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        State
                    </label>

                    <input type="text"
                        name="state"
                        id="state"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Madhya Pradesh" required readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        District
                    </label>

                    <input type="text"  id="district"
                        name="district"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Indore" required readonly>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Address
                    </label>

                    <textarea name="address"
                        rows="3"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Full Address" required> </textarea>
                </div>

            </div>

            <button type="submit"
                
                class="mt-6 w-full bg-[#0049af] text-white py-3 rounded-lg font-bold">
                Next
            </button>
        </form>
    </div>


    <!-- STEP 2 : JOB DETAILS -->
    <div id="step2"
        class="{{ session('step') == 2 ? '' : 'hidden' }} bg-white p-8 rounded-xl shadow-md border-t-4 custom-border">

        <h2 class="text-2xl font-bold mb-6 text-gray-900">
            Post a Job
        </h2>

       

        <form action="/jobs/store-by-company" method="POST" class="space-y-4">

            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Job Title
                </label>

                <input type="text"
                    name="title"
                    class="w-full px-4 py-2 border rounded-lg"
                    placeholder="Software Developer"
                    required>
            </div>

            <!-- CATEGORY -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Category
                </label>

                <select name="category"
                    class="w-full px-4 py-2 border rounded-lg appearance-none"
                    required>

                    <option value="">-- Select Category --</option>

                    @foreach($categories as $cat)

                    <option value="{{ $cat->id }}">
                        {{ $cat->name }}
                    </option>

                    @endforeach

                </select>
            </div>

            <!-- LOCATION -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Location
                </label>

                <input type="text"
                    name="location"
                    class="w-full px-4 py-2 border rounded-lg"
                    placeholder="Indore"
                    required>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Min Salary
                    </label>

                    <input type="text"
                        name="salary_min"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="3 LPA"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Max Salary
                    </label>

                    <input type="text"
                        name="salary_max"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="6 LPA"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Gender Preferance
                    </label>

                    <input type="text"
                        name="who_can_apply"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="male/female"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        No Of Openings
                    </label>

                    <input type="number"
                        name="no_of_openings"
                        min="1"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="5"
                        required>
                </div>

                <!-- <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Roles & Responsibility
                    </label>

                    <input type="text"
                        name="roles_responsibility"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Roles & Responsibility"
                        required>
                </div> -->

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Experience Required
                    </label>

                    <select name="experience" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="">All Experience</option>
                        <option value="Fresher">Fresher</option>
                        <option value="Less than 1 year">Less than 1 year</option>
                        <option value="Less than 2 years">Less than 2 years</option>
                        <option value="Less than 3 years">Less than 3 years</option>
                        <option value="Less than 4 years">Less than 4 years</option>
                        <option value="More than 4 years">More than 4 years</option>
                    </select>

                    <!-- <input type="text"
                        name="experience"
                        
                        placeholder="2-3 years"
                        required> -->
                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                       Age Criteria
                    </label>

                    <input type="text"
                        name="age_criteria"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Enter Age criteria"
                        required>
                </div>

                 <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                       Qualification
                    </label>

                    <input type="text"
                        name="qualification_eligibility"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Enter Qualification"
                        required>
                </div>

                <!-- <div class="md:col-span-2">

                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Skills Required
                    </label>

                    <input type="text"
                        name="skills_required"
                        class="w-full px-4 py-2 border rounded-lg"
                        placeholder="PHP, Laravel, MySQL"
                        required>
                </div> -->

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Job Type
                    </label>

                    <select name="job_type"
                        class="w-full px-4 py-2 border rounded-lg appearance-none"
                        required>

                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Contract">Contract</option>
                        <option value="Remote">Remote</option>

                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Required Document
                    </label>

                    <textarea name="required_document"
                        placeholder="Required Document"
                        rows="4"
                        class="w-full px-4 py-2 border rounded-lg"
                        required></textarea>
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Job Description
                    </label>

                    <textarea name="description"
                        placeholder="Description"
                        rows="4"
                        class="w-full px-4 py-2 border rounded-lg"
                        required></textarea>
                </div>

                 <input type="hidden" name="posted_by_type" value="company">

            <!-- BUTTONS -->
                <div class="flex gap-4">

                    <button type="button"
                        onclick="prevStep()"
                        class="w-1/2 bg-gray-400 text-white py-3 rounded-lg font-bold">

                        Back
                    </button>

                    <button type="submit"
                        class="w-1/2 bg-[#0049af] text-white py-3 rounded-lg font-bold">

                        Post Job
                    </button>

                </div>

        </form>
    </div>

</div>


    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script>


document.getElementById('pincode').addEventListener('keyup', function () {

    let pincode = this.value;

    // Only when 6 digits entered
    if (pincode.length === 6) {

        fetch(`https://api.postalpincode.in/pincode/${pincode}`)
            .then(response => response.json())
            .then(data => {

                if (data[0].Status === "Success") {

                    let postOffice = data[0].PostOffice[0];

                    document.getElementById('district').value = postOffice.District;
                    document.getElementById('state').value = postOffice.State;

                } else {

                    document.getElementById('district').value = '';
                    document.getElementById('state').value = '';

                    alert('Invalid Pincode');
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

});

    setTimeout(() => {
        let msg = document.querySelector('.alert, .bg-green-100');
        if (msg) msg.style.display = 'none';
    }, 3000);


    // function nextStep() {
    //     document.getElementById('step1').classList.add('hidden');
    //     document.getElementById('step2').classList.remove('hidden');
    // }

    function prevStep() {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
    }
</script>
@endsection
<style>
    select{
    border:1px solid #d1d5db !important;
    background-color:#fff !important;
}


    </style>