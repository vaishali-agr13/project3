@extends('layouts.app')

@section('content')


<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap lg:flex-nowrap -mx-4 justify-center">
        
            <div class="w-full lg:w-2/3 px-4 mb-8 mx-auto">
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                            <p class="text-blue-600 font-medium text-lg">{{ $job->company_name }} • {{ $job->district }}</p>
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
                           
                            <p class="font-bold text-gray-800">{{ optional($job->categoryData)->name ?? 'No Category' }}</p>
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
                     @if(!empty($job->roles_responsibility) && $job->roles_responsibility != 'NA' && $job->roles_responsibility != 'na')

                        <div class="prose max-w-none text-gray-700 leading-relaxed" >
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Roles & Responsibilities</h3>
                                {{$job->roles_responsibility}}
                        </div>
                    @endif

                        @if(!empty($job->skills_required) && $job->skills_required != 'NA' && $job->skills_required != 'na')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Skills Required</h3>
                                {{ $job->skills_required }}
                            </div>
                        @endif

                        @if(!empty($job->who_can_apply) && $job->who_can_apply != 'NA' && $job->who_can_apply != 'na')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Who can apply</h3>
                                {{ $job->who_can_apply }}
                            </div>
                        @endif

                        @if(!empty($job->no_of_openings) && $job->no_of_openings != '0')
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Number of openings</h3>
                                {{ $job->no_of_openings }}
                            </div>
                        @endif

                   
                    
                    <a href="{{ route('jobs.apply.form', $job->id) }}"
                    class="bg-[#0049af] text-white px-4 py-2 rounded-lg ml-auto block w-fit">
                        Apply Now
                    </a>
                    <!-- <button type="button" class="bg-[#0049af]  text-white px-4 py-2 rounded-lg ml-auto block transition">
                       Apply Now
                    </button> -->

                </div>
                
            </div>

           

        </div>
    </div>
</div>


@endsection
