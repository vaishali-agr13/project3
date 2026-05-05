@extends('layouts.app')

@section('content')
<!--pop up code -->

<!-- <div id="thankPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999;">
  
  <div style="background:white; width:320px; padding:20px; border-radius:8px; text-align:center; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:black;">
    
    <span onclick="closeThankPopup()" style="position:absolute; top:10px; right:15px; cursor:pointer;">&times;</span>

    <h3>Thank You 🎉</h3>
    <p>Your application has been submitted successfully.</p>


     <a href="https://wa.me/919876543210" target="_blank"
       style="display:block; margin-top:15px; background:#25D366; color:white; padding:10px; border-radius:5px; text-decoration:none;">
        Chat on WhatsApp
    </a>

    <a href="https://chat.whatsapp.com/H4PArHFPz8L0W4L3msdTKP" target="_blank"
       style="display:block; margin-top:10px; background:#0049af; color:white; padding:10px; border-radius:5px; text-decoration:none;">
        Join Community
    </a>



  </div>
</div> -->


<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap lg:flex-nowrap -mx-4">
        
            <div class="w-full lg:w-2/3 px-4 mb-8">
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-blue-600 font-medium text-lg">{{ $job->company_name }} • {{ $job->location }}</p>
                        </div>
                        <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                            {{ $job->job_type }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 border-t border-b py-6">
                        <div>

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
                            <p class="text-gray-500 text-sm">Salary</p>
                            <p class="font-bold text-gray-800">₹ {{ formatSalary($job->salary_min) }} - ₹{{ formatSalary($job->salary_max) }} </p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Category</p>
                           
                            <p class="font-bold text-gray-800">{{ $job->categoryData->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Posted On</p>
                            <p class="font-bold text-gray-800">{{ $job->created_at->format('d M, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Experience</p>
                            <p class="font-bold text-gray-800">{{ $job->experience }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">{{$applicationCount}} applicants</p>
                        </div>

                        
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Job Description</h3>
                            {!! html_entity_decode($job->description) !!}
                        
                        <!-- <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">Requirements</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Strong understanding of Laravel and PHP.</li>
                            <li>Experience with Tailwind CSS or Bootstrap.</li>
                            <li>Ability to work in a fast-paced environment.</li>
                        </ul> -->
                    </div>
                    <div class="prose max-w-none text-gray-700 leading-relaxed" >
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Roles & Responsibilities</h3>
                            {{$job->roles_responsibility}}
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed" > 
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Skills Required</h3>

                           @php
                                $skills = is_string($job->skills_required)
                                    ? json_decode($job->skills_required, true)
                                    : $job->skills_required;
                            @endphp

                            @if(is_array($skills))
                                @foreach($skills as $skill)
                                    <span>{{ $skill }},</span>
                                @endforeach
                            @endif
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Who can apply</h3>
                            {{$job->who_can_apply}}
                    </div>

                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Number of openings</h3>
                            {{$job->no_of_openings}}
                    </div>

                    <button type="button" onclick="toggleApplyForm()" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg ml-auto block transition">
                       Apply Now
                    </button>

                </div>
                
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <div id="applyForm" class="hidden mt-4 bg-white p-6 rounded-xl shadow-md border-t-4 custom-border sticky top-10">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Apply Now</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-4 text-sm font-medium">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="full_name"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="John Doe" required>                       
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="john@example.com" required>                        
                        </div>

                         <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                            <input type="number" name="phone"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Enter Phone No" required>                        
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Resume (PDF)</label>
                            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center hover:border-blue-500 transition cursor-pointer">
                                <input type="file" name="resume" accept=".pdf" class="hidden" id="resumeUpload" required>
                                <p id="file-name"></p>

                                <label for="resumeUpload" class="cursor-pointer text-gray-500">
                                    <i class="fas fa-cloud-upload-alt text-2xl mb-2 block"></i>
                                    <span class="text-sm">Click to upload PDF</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Cover Letter (Optional)</label>
                            <textarea name="cover_letter" rows="3"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Why are you a good fit?"></textarea>                        
                        </div>

                        <button type="submit" class="w-full text-white font-bold submit-btn py-3 rounded-lg hover:bg-blue-700 shadow-lg transform active:scale-95 transition duration-200">
                            Submit Application
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 mt-4 text-center">
                        By clicking Apply, you agree to our Terms of Service.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
 console.log('event outside');
    const input = document.getElementById('resumeUpload');
    const fileText = document.getElementById('file-name');

    input.addEventListener('change', function(e) {
        console.log('event inside');
        fileText.innerText = e.target.files.length > 0 
            ? e.target.files[0].name 
            : 'No file selected';
    });

});

   function toggleApplyForm() {
        const form = document.getElementById('applyForm');
        form.classList.toggle('hidden');
    }

</script>
@endsection
@push('scripts')

@endpush
<!--@if(session('success'))
// <script>
//     window.onload = function() {
//         document.getElementById('thankPopup').style.display = 'block';
//     }
// </script>
@endif-->