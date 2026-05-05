@extends('layouts.app')

@section('content')



<!-- Popup -->
<div id="welcomePopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999;">
  
  <div style="
      background:white;
      width:90%;
      max-width:500px;
      padding:35px 30px;
      border-radius:15px;
      text-align:center;
      position:absolute;
      top:50%;
      left:50%;
      transform:translate(-50%, -50%);
      color:black;
      box-shadow:0 10px 40px rgba(0,0,0,0.2);
  ">
    
    <!-- Close Button -->
    <span onclick="closePopup()" 
          style="position:absolute; top:12px; right:18px; font-size:26px; cursor:pointer; color:black;">
        &times;
    </span>

    <!-- Logo -->
    <div style="display:flex; justify-content:center; align-items:center; margin-bottom:15px;">
      <img src="{{asset('images/company-logo.png') }}" alt="Logo" style="height:90px;">
    </div>

    <!-- Title -->
    <h3 style="font-size:32px; font-weight:700; margin-bottom:10px;">
      Welcome 👋
    </h3>

    <!-- Subtitle -->
    <p style="color:gray; font-size:16px; margin-bottom:15px;">
      Welcome to our website! 🚀
    </p>

  </div>
</div>


<section class="hero">
  <div class="hero-text">

    <h2 class="text-3xl font-bold leading-tight mb-3">
      Find Your <span class="text-blue-600">Dream Job</span> Easily
    </h2>

    <p class="text-gray-600 mb-5">
      Search thousands of jobs from top companies.
    </p>
  
    <form action="{{ url('/find-jobs') }}" method="GET">

        <div class="search-box">
                <div class="search-item">
                    <span>🔍</span>
                    <input type="text" name="title" placeholder="Job title">
                </div>

                <div class="divider"></div>

                <div class="search-item">
                    <span>📍</span>
                    <input type="text" name="location" placeholder="Location">
                </div>

                <div class="divider"></div>

                <!-- <div class="search-item">
                    <select  name="category">
                      <option value="" disabled selected>
                          Select Category
                      </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}"
                                  {{ request('category') == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                    
                        @endforeach

                    </select>
                </div> -->


               <div class="search-item relative" x-data="{ open: false, selected: '{{ request('category') ?? '' }}' }">
    
                  <div @click="open = !open" class="category-text flex items-center cursor-pointer space-x-3 w-full">
                      
                      <div class="text-xl">📂</div>
                      
                      <div class="flex flex-col overflow-hidden">
                          <template x-if="selected !== ''">
                              <span class="text-[10px] text-blue-500 font-bold uppercase leading-none mb-1">Category</span>
                          </template>

                          <span class="text-gray-700 font-semibold leading-tight truncate" 
                                x-text="selected === '' ? 'Select Category' : selected">
                          </span>
                      </div>

                      <svg class="w-4 h-4 text-gray-400 transition-transform duration-300 ml-auto" 
                          :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                  </div>

                  <input type="hidden" name="category" :value="selected">

                  <div x-show="open" 
                      @click.away="open = false"
                      x-cloak
                      x-transition:enter="transition ease-out duration-100"
                      x-transition:enter-start="opacity-0 scale-95"
                      x-transition:enter-end="opacity-100 scale-100"
                      class="absolute left-0 top-full mt-2 w-64 bg-white border border-gray-100 rounded-xl shadow-2xl z-50">
                      
                      <div x-show="open" x-transition class="category-dropdown">
                          <div @click="selected = ''; open = false" 
                              class="px-4 py-2 text-xs text-gray-400 hover:bg-gray-50 cursor-pointer rounded-lg mb-1">
                              None (Clear)
                          </div>

                          @foreach($categories as $category)
                              <div @click="selected = '{{ $category->name }}'; open = false" 
                                  class="flex items-center justify-between px-4 py-2.5 hover:bg-blue-50 rounded-lg cursor-pointer transition group"
                                  :class="selected === '{{ $category->name }}' ? 'bg-blue-50' : ''">
                                  
                                  <span class="text-gray-600 group-hover:text-blue-600 font-medium text-sm">{{ $category->name }}</span>
                                  
                                  <template x-if="selected === '{{ $category->name }}'">
                                      <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                          <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                      </svg>
                                  </template>
                              </div>
                          @endforeach
                      </div>
                  </div>
           </div>
                <button type="submit">Search</button>
        </div>

     </form>
  </div>

  <div class="hero-img">
    <img src="{{ asset('images/top-header-image.png') }}">
  </div>
</section>

<!-- Categories -->
<section class="section">
  <h3>Popular Categories</h3>
  
  <div class="grid">
    @forelse($categories as $category)
    
       <div class="card  category-card">
        <a href="{{ url('/categories/'.$category->id) }}">

        <!-- ICON -->
          <div class="category-icon">
              <i class="fas {{ !empty($category->icon) ? $category->icon : 'fa-folder' }}"></i>
          </div>
         <p class="cat-name"> {{$category->name}}</p>

          <p style="color:grey"> {{$category->jobs_count}} Jobs Avilaible </p>
       </a>
       </div>
    
     @empty
    @endforelse
  </div>
</section>

<section class="job-section">
  <div class="container">
    
    <!-- LEFT CONTENT -->
    <div class="left-content">
      <h2>Explore Job Opportunities in <br> Popular Roles</h2>
      
      <p>
        Explore top job opportunities in popular roles across various industries.
        Find the perfect fit for your skills and ambitions, and take the next step
        in your career today.
      </p>

      <a href="/find-jobs" class="btn-explore">Explore Jobs</a>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="right-image">
      <img src="{{ asset('images/job-seekers.webp') }}" alt="job illustration">
    </div>

  </div>
</section>


<section class="section">
  <h3>Jobs of the Day</h3>

  <div class="grid">


   @forelse($featuredJobs as $job)
            <div class="card job-card category-card">
                    @php
                        $days = \Carbon\Carbon::parse($job->created_at)->diffInDays(now());
                    @endphp

                    @if($days < 3)
                        <img style="width:20px;height:20px;" src="{{ asset('images/new.gif') }}" class="company-logo">

                    @endif                   
                  
                    <h4>{{ $job->title }}</h4>
                    <p>{{ $job->company_name }}</p>
                    <p> {{ \Illuminate\Support\Str::limit($job->location, 10, '...') }}</p>

                    

                   <a href="{{ route('jobs.show', $job->id) }}" class="block mt-4">
                        <button class="apply-btn">View Details →</button>    
                    </a>

                    <div class="bottom-row">
                        <div class="share-icons">
                            <a href="https://wa.me/?text={{ urlencode($job->title . ' ' . route('jobs.show', $job->id)) }}" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                            </a>

                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('jobs.show', $job->id)) }}" target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>

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

                        <div class="salary">
                            ₹ {{ formatSalary($job->salary_min) }} - ₹{{ formatSalary($job->salary_max) }}
                        </div>
                    </div>

                    
          </div>

           
        @empty
   @endforelse
  </div>
</section>


<section class="counter-section">

<h3 class="counter-heading">Our Platform in Numbers</h3>
  <p class="counter-subtext">Trusted by thousands of job seekers and companies</p>
    <div class="counter-wrapper">
          <div class="counter-box">
            <h2>9350+</h2>
            <p>Jobs Available</p>
          </div>

          <div class="counter-box">
            <h2>1670+</h2>
            <p>Companies</p>
          </div>

          <div class="counter-box">
            <h2>27000+</h2>
            <p>Candidates</p>
          </div>

          <div class="counter-box">
            <h2>7121+</h2>
            <p>Jobs Placements </p>
          </div>
     </div>
</section>

<!-- <section class="section">
  <div class="job-alert-container">

    <div class="job-alert-left">
      <h2>Never miss out <span style="color: #0049af">on the latest career</span> opportunities</h2>
      
      <p>
        Get daily alerts and stay ahead!
      </p>

      <div class="job-alert-form">
        <input type="email" placeholder="Enter your email">
        <button>Subscribe</button>
      </div>
    </div>

\    <div class="job-alert-right">
      <img src="{{ asset('images/job-alert.png') }}" alt="job alert">
    </div>

  </div>
</section> -->



<!-- 🔹 WHATSAPP COMMUNITY SECTION -->
<section class="py-16 text-white" style="background:#0049af; position:relative; z-index:1;">
    <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">

    <!-- LEFT CONTENT -->
      <div>
          <h2 class="text-3xl font-bold mb-4 text-white">
            Join Our Community 🚀
          </h2>

          <p class="mb-6 text-purple-100">
            Stay updated with the latest job openings, internships, and hiring alerts.  
            Join our WhatsApp community and never miss an opportunity.
          </p>

          <ul class="space-y-2 mb-6 text-purple-100">
            <li>✔ Daily Job Updates</li>
            <li>✔ Internship Alerts</li>
            <li>✔ Direct Hiring Notifications</li>
          </ul>

          <a href="https://chat.whatsapp.com/YOUR-LINK-HERE" target="_blank" style="color:black;"
            class="inline-block bg-white blue-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
            Join WhatsApp Community
          </a>

          <p class="mt-4 text-sm text-purple-200">
            📞 Contact: {{ $profile->phone ?? '+91 9039023534' }}
          </p>
      </div>

    <!-- RIGHT IMAGE -->
    <div>
      <img src="{{ asset('images/whatsapp-community.png') }}" 
           class="w-full rounded-2xl shadow-lg">
    </div>

  </div>
</section>




<!-- Companies -->
<section class="section">
  <h3>Top Companies Hiring</h3>
  <div class="grid">
    <div class="card category-card">
      <img src="{{ asset('images/Google_logo.svg') }}" class="company-logo">
      <h4>Google</h4>
      <p style="color:grey">Software Engineer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/Amazon_logo.svg') }}" class="company-logo">
      <h4>Amazon</h4>
      <p style="color:grey">Backend Developer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/Microsoft_logo.svg') }}" class="company-logo">
      <h4>Microsoft</h4>
      <p style="color:grey">UI/UX Designer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/vipdigitalhub.jpg') }}" class="company-logo">
      <h4>VIP DIgital Hub</h4>
      <p style="color:grey">Laravel Developer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/Tech_Mahindra-Logo.png') }}" class="company-logo">
      <h4>Tech Mahindra</h4>
      <p style="color:grey">Java Developer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/softobiz.jpg') }}" class="company-logo">
      <h4>Softobiz Technology</h4>
      <p style="color:grey">Python Developerr</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/impetus.png') }}" class="company-logo">
      <h4>Impetus</h4>
      <p style="color:grey">Angular Developer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/cis.jpg') }}" class="company-logo">
      <h4>CIS</h4>
      <p style="color:grey">Website Designer</p>
    </div>
    <div class="card category-card">
      <img src="{{ asset('images/synapseindia.jpeg') }}" class="company-logo">
      <h4>Synapse India</h4>
      <p style="color:grey">Mern Stack Developer</p>
    </div><div class="card category-card">
      <img src="{{ asset('images/ondoor.png') }}" class="company-logo">
      <h4>Ondoor Concepts</h4>
      <p style="color:grey">Azure Developer</p>
    </div>

  </div>
</section>

<section class="how-section">
  <h3>How It Works</h3>

  <div class="how-container">

      <div class="how-card">
        <div class="step">01</div>
        <div class="icon">👤</div>
        <h4>Create Account</h4>
        <p>Sign up and build your profile to get started with your job search.</p>
      </div>

      <div class="how-card">
        <div class="step">02</div>
        <div class="icon">🔍</div>
        <h4>Search Jobs</h4>
        <p>Find jobs that match your skills, interests, and location easily.</p>
      </div>

      <div class="how-card">
        <div class="step">03</div>
        <div class="icon">🚀</div>
        <h4>Apply & Get Hired</h4>
        <p>Apply to jobs and connect with employers to land your dream role.</p>
      </div>

  </div>
</section>


<section class="reviews-section">
  <h2>What Candidates Say</h2>

  <div class="reviews-container">

    <div class="review-card">
      <img src="{{ asset('images/riya.jpg') }}" alt="user">
      <h4>Riya Sharma</h4>
      <p class="role">Frontend Developer</p>
      <p class="review-text">
        "This platform helped me land my first job within 2 weeks. The process was smooth and easy!"
      </p>
      <div class="stars">★★★★★</div>
    </div>

    <div class="review-card">
      <img src="{{ asset('images/aman.jpg') }}" alt="user">
      <h4>Aman Verma</h4>
      <p class="role">Backend Developer</p>
      <p class="review-text">
        "Great experience! The job listings are genuine and updated regularly."
      </p>
      <div class="stars">★★★★☆</div>
    </div>

    <div class="review-card">
      <img src="{{ asset('images/shikha.jpg') }}" alt="user">
      <h4>Shikha Gupta</h4>
      <p class="role">UI/UX Designer</p>
      <p class="review-text">
        "Loved the UI and filters. Found a perfect remote job easily!"
      </p>
      <div class="stars">★★★★★</div>
    </div>

    <div class="review-card">
      <img src="{{ asset('images/kirti.jpg') }}" alt="user">
      <h4>Kirti Agrawal</h4>
      <p class="role">Java Developer</p>
      <p class="review-text">
        "Loved the UI and filters. Found a perfect remote job easily!"
      </p>
      <div class="stars">★★★★★</div>
    </div>

  </div>
</section>

<section class="advice-section">
  <h3>Career Advice & Resources</h3>

  <div class="advice-container">

    <!-- Card 1 -->
    <div class="advice-card">
      <img src="{{ asset('images/photo1.jpg') }}" alt="Resume Tips">
      <div class="advice-content">
        <h4>How to Build a Strong Resume</h4>
        <p>Learn how to create a resume that stands out to recruiters.</p>
        <a href="#">Read More →</a>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="advice-card">
      <img src="{{ asset('images/photo2.jpg') }}" alt="Interview Tips">
      <div class="advice-content">
        <h4>Top Interview Tips</h4>
        <p>Prepare confidently and crack your next interview easily.</p>
        <a href="#">Read More →</a>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="advice-card">
      <img src="{{ asset('images/photo3.jpg') }}" alt="Career Growth">
      <div class="advice-content">
        <h4>Career Growth Strategies</h4>
        <p>Boost your career with smart planning and skill development.</p>
        <a href="#">Read More →</a>
      </div>
    </div>

  </div>
</section>

@endsection

<script>
window.onload = function() {
    document.getElementById('welcomePopup').style.display = 'block';
};

function closePopup() {
    document.getElementById('welcomePopup').style.display = 'none';
}
</script>