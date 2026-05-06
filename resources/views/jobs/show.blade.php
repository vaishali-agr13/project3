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
       style="display:block; margin-top:10px; background:#76ac20; color:white; padding:10px; border-radius:5px; text-decoration:none;">
        Join Community
    </a>



  </div>
</div> -->


<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap lg:flex-nowrap -mx-4 justify-center">
        
            <div class="w-full lg:w-2/3 px-4 mb-8 mx-auto">
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

                    <div class="prose max-w-none text-gray-700 leading-relaxed break-words overflow-hidden">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Job Description</h3>
                            {!! html_entity_decode($job->description) !!}
                        
                        <!-- <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">Requirements</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Strong understanding of Laravel and PHP.</li>
                            <li>Experience with Tailwind CSS or Bootstrap.</li>
                            <li>Ability to work in a fast-paced environment.</li>
                        </ul> -->
                    </div>
                     @if(!empty($job->roles_responsibility) && $job->roles_responsibility != 'NA')

                        <div class="prose max-w-none text-gray-700 leading-relaxed" >
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Roles & Responsibilities</h3>
                                {{$job->roles_responsibility}}
                        </div>
                    @endif

                        @if(!empty($job->skills_required) && $job->skills_required != 'NA')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Skills Required</h3>
                                {{ $job->skills_required }}
                            </div>
                        @endif

                        @if(!empty($job->who_can_apply) && $job->who_can_apply != 'NA')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Who can apply</h3>
                                {{ $job->who_can_apply }}
                            </div>
                        @endif

                        @if(!empty($job->no_of_openings)&& $job->no_of_openings != '0')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Number of openings</h3>
                                {{ $job->no_of_openings }}
                            </div>
                        @endif

                   
                    
                    <a href="{{ route('jobs.apply.form', $job->id) }}"
                    class="bg-lime-600 text-white px-4 py-2 rounded-lg ml-auto block w-fit">
                        Apply Now
                    </a>
                    <!-- <button type="button" class="bg-lime-600  text-white px-4 py-2 rounded-lg ml-auto block transition">
                       Apply Now
                    </button> -->

                </div>
                
            </div>

           

        </div>
    </div>
</div>


@endsection
