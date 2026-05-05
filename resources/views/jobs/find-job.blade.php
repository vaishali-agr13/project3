<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@extends('layouts.app')
@section('content')
<main>
<div class="jobs-hero">
  <!-- Hero Text -->
  <div class="hero-content header-text">
    <h1>The official <span class="highlight">IT Jobs</span> site</h1>
    <p>“JobBox is our first stop whenever we're hiring a PHP role. We've hired 10 PHP developers in the last few years, all thanks to JobBox.” — Andrew Hall, Elite JSC.</p>
  </div>
        <form action="{{ url('/find-jobs') }}" method="GET">
                           
                <!-- Search Box -->
          <div class="search-box">
          
              <div class="search-item">
                  <span>🔍</span>
                  <input type="text" name="title" value="{{ request('title') }}" placeholder="Job title">
              </div>

              <div class="divider"></div>

              <div class="search-item">
                  <span>📍</span>
                  <input type="text" name="location" value="{{ request('location') }}" placeholder="Location" value="">
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
    
                <div @click="open = !open" class="category-text flex items-center cursor-pointer space-x-3 min-w-[180px]">
                    
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
                    class="absolute left-0 top-full mt-2 min-w-[220px] w-auto max-w-xs bg-white border border-gray-100 rounded-xl shadow-2xl z-50">
                    
                    <div class="p-2 max-h-60 overflow-y-auto custom-scrollbar">
                        <div @click="selected = ''; open = false" 
                            class="px-4 py-2 text-xs text-gray-400 hover:bg-gray-50 cursor-pointer rounded-lg mb-1">
                            None (Clear)
                        </div>

                        @foreach($categories as $category)
                              <div 
                                  @click="selected = '{{ $category->name }}'; open = false" 
                                  class="flex items-center px-4 py-2.5 hover:bg-blue-50 rounded-lg cursor-pointer transition group"
                                  :class="selected === '{{ $category->name }}' ? 'bg-blue-50' : ''">

                                  <span class="block w-full text-left text-gray-600 group-hover:text-blue-600 font-medium text-sm truncate">
                                      {{ $category->name }}
                                  </span>

                                  <template x-if="selected === '{{ $category->name }}'">
                                      <svg class="w-4 h-4 text-blue-500 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
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
  <!-- Categories -->
 <div class="categories-container">
    <div class="swiper categorySwiper">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <!-- Slide must be the direct child of swiper-wrapper -->
                <div class="swiper-slide">
                    <a href="{{ url('/categories/'.$category->id) }}" style="text-decoration: none; display: block; width: 100%;">
                        <div class="category-box">
                            <div class="category-info">
                                <i style="font-size: 24px; color:#0049af" class="fas {{ !empty($category->icon) ? $category->icon : 'fa-folder' }}"></i>
                                <p class="cat-name" style="font-weight: bold; margin: 10px 0 5px; color: #333;">{{$category->name}}</p>
                                <span style="font-size: 12px; color: #888;">{{$category->jobs_count}} Jobs Available</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Dots -->
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="jobs-page">

<button class="filter-toggle" onclick="toggleFilters()">
  ☰ Filters
</button>

  <!-- LEFT SIDEBAR (SEPARATE FORM) -->
  <aside class="filters">

      <button onclick="toggleFilters()" style="float:right; font-size:18px; border:none; background:none; cursor:pointer;">
      ✖
    </button>

    <form method="GET" action="{{ url('/find-jobs') }}" id="filterForm">

      <h3>All Filters</h3>

      <!-- Job Type -->
      <div class="filter-group">
        <h4>Job Type</h4>
        <label>
          <input type="checkbox" name="job_type[]" value="Full-Time"
          {{ in_array('Full-Time', request('job_type', [])) ? 'checked' : '' }}>
         <span>Full Time</span>
        </label>

        <label>
          <input type="checkbox" name="job_type[]" value="Part-Time"
          {{ in_array('Part-Time', request('job_type', [])) ? 'checked' : '' }}>
          <span>Part Time</span>
        </label>

        
      </div>

      <!-- Location -->
      <div class="filter-group">
        <h4>Location</h4>
        <label>
          <input type="checkbox" name="locations[]" value="Delhi"
          {{ in_array('Delhi', request('locations', [])) ? 'checked' : '' }}>
          <span>Delhi</span>
        </label>

        <label>
          <input type="checkbox" name="locations[]" value="Mumbai"
          {{ in_array('Mumbai', request('locations', [])) ? 'checked' : '' }}>
        <span>Mumbai</span>
        </label>

         <label>
          <input type="checkbox" name="locations[]" value="Pune"
          {{ in_array('Pune', request('locations', [])) ? 'checked' : '' }}>
          <span>Pune</span>
        </label>
         <label>
          <input type="checkbox" name="locations[]" value="Hyderabad"
          {{ in_array('Hyderabad', request('locations', [])) ? 'checked' : '' }}>
          <span>Hyderabad</span>
        </label>
         <label>
          <input type="checkbox" name="locations[]" value="Noida"
          {{ in_array('Noida', request('locations', [])) ? 'checked' : '' }}>
          <span>Noida</span>
        </label>

         <label>
          <input type="checkbox" name="locations[]" value="Bengaluru"
          {{ in_array('Bengaluru', request('locations', [])) ? 'checked' : '' }}>
          <span>Bengaluru</span>
        </label>

        
         <label>
          <input type="checkbox" name="locations[]" value="Indore"
          {{ in_array('Indore', request('locations', [])) ? 'checked' : '' }}>
          <span>Indore</span>
        </label>
        
         <label>
          <input type="checkbox" name="locations[]" value="Bhopal"
          {{ in_array('Bhopal', request('locations', [])) ? 'checked' : '' }}>
          <span>Bhopal</span>
        </label>

      </div>

      <!-- Salary -->
      <div class="filter-group">
        <h4>Salary</h4>
        <label>
          <input type="radio" name="salary" value="0-3"
          {{ request('salary') == '0-3' ? 'checked' : '' }}>
          <span>0-3 LPA</span>
        </label>

        <label>
          <input type="radio" name="salary" value="3-6"
          {{ request('salary') == '3-6' ? 'checked' : '' }}>
         <span>3-6 LPA</span>
        </label>
        <label>
          <input type="radio" name="salary" value="6-10"
          {{ request('salary') == '6-10' ? 'checked' : '' }}>
         <span>6-10 LPA</span>
        </label>
        <label>
          <input type="radio" name="salary" value="10-15"
          {{ request('salary') == '10-15' ? 'checked' : '' }}>
         <span>10-15 LPA</span>
        </label>

      </div>

      <!-- Buttons -->
      <button type="submit" class="filter-btn">Apply Filters</button>

      <a href="{{ url('/find-jobs') }}" class="clear-btn">Clear All</a>

    </form>

  </aside>
<div class="overlay" onclick="toggleFilters()"></div>

  <!-- RIGHT JOB LIST -->
  <main class="job-listing">
    <div class="job-container">
          @forelse($jobs as $job)
            <div class="job-card">

              <div class="job-header" style="position:relative;">
                @php
                    $days = \Carbon\Carbon::parse($job->created_at)->diffInDays(now());
                @endphp

                @if($days < 3)
                  <img style="width:20px;height:20px;" src="{{ asset('images/new.gif') }}" class="new-gif company-logo">


                @endif



                <div class="job-company">
                  <h3>{{$job->company_name}}</h3>
                  <p>
                    {{ \Illuminate\Support\Str::limit($job->location, 10, '...') }}
                  </p>
                </div>
              </div>

              <div class="job-title">
                <h2>{{$job->title}}</h2>
                <p>{{$job->job_type}} • 1 year ago</p>
              </div>

              <div class="job-description">

              {!! Str::limit(strip_tags($job->description), 120) !!}
                
                <!-- {{ \Illuminate\Support\Str::limit($job->description, 10, '...') }} -->
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

              <div class="job-footer">
                <p class="salary">₹ {{ formatSalary($job->salary_min) }} - ₹{{ formatSalary($job->salary_max) }} </p>

                <a href="{{ url('/jobs/'.$job->id) }}" class="apply-btn">
                  View Details
                </a>
              </div>

            </div>
          @empty
 
          <div style="width:100%; text-align:center; padding:40px;">
            <h2 style="color:#444;">No Jobs Found</h2>
            <p style="color:gray;">Try changing filters or search keyword</p>
          </div>
         @endforelse
   </div>
  </main>

</div>
</main>
@endsection

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- 3. Initialize Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.categorySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            // Responsive breakpoints
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
                1280: {
                    slidesPerView: 5,
                }
            }
        });
    });
</script>


<script>
window.onload = function () {
    var form = document.getElementById('filterForm');

    var inputs = form.querySelectorAll('input[type="checkbox"], input[type="radio"]');

    inputs.forEach(function(input) {
        input.onchange = function () {
            form.submit();
        };
    });
};
</script>

<script>
function toggleFilters() {
    document.querySelector('.filters').classList.toggle('active');
    document.querySelector('.overlay').classList.toggle('active');
}
</script>

<style>
    /* Hero Section */
html, body {
  height: auto;
}
body {
    margin: 0;

  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
main {
  flex: 1;
}

.jobs-hero,
.categories-container,
.jobs-page {
  margin-bottom: 0 !important;   /* 🔥 MUST */
}


.jobs-hero {
  background-color: #e7f3fd;
  padding: 60px 20px;
  text-align: center;
  color: #00395b;

  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;   /* IMPORTANT */
}

.jobs-hero .hero-content h1 {
  font-size: 2.5rem;
  margin-bottom: 15px;
}

.jobs-hero .hero-content .highlight {
  color: #0049af;
}

.jobs-hero .hero-content p {
  font-size: 1rem;
  max-width: 700px;
  margin: 0 auto 40px;
}



/* Search Box */
.search-box {
 display: flex;
  align-items: center;
  gap: 10px;

  width: 100%;
  max-width: 800px;

  background: #fff;
  border-radius: 50px;
  padding: 10px 15px;

  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  position: relative;
  z-index: 2;
}

.divider {
  width: 1px;
  height: 25px;
  background: #ddd;
}



.search-box select,
.search-box input {
  width: 100%;
  height: 40px;   /* IMPORTANT FIX */
  padding: 0 10px;
  border: none;
  outline: none;
  font-size: 14px;
  color: #000;
  background: transparent;
}

.search-box,
.categories {
  position: relative;
}

.search-box input {
  flex: 1;
}

.search-box button {
  padding: 0 20px;
  border: none;
  border-radius: 10px;
  background-color: #fff;
  color: #3b59ff;
  font-weight: bold;
  cursor: pointer;
  height: 100%;
}

/* Categories */
.categories {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;

  margin-top: 20px;   /* IMPORTANT */
  position: relative;
  z-index: 1;
}

.category-box {
  background: #fff;
        border-radius: 15px;
        padding: 25px 20px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid #f0f0f0;
        cursor: pointer;
        text-decoration: none !important;
}

.category-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(108, 30, 150, 0.1);
}

.category-box i {
  font-size: 2rem;
  color: #3b59ff;
}

.category-info p {
  margin: 0;
  font-weight: bold;
}

.category-info span {
   color: #888;
        font-size: 13px;
}

 .swiper-pagination-bullet-active {
        background: #0049af !important; /* Your Purple Color */
    }
    
    .swiper-pagination {
        position: relative !important;
        margin-top: 30px !important;
    }

/* Header Text */
.header-text {
  text-align: center;
  margin: 20px 0;
  font-size: 18px;
  font-weight: 500;
  color: #00395b;
}

.categories-container {
        padding: 40px 0;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
}


/* Page Layout */
.jobs-page {
  display: flex;
  gap: 20px;
   min-height: 80vh;
    align-items: flex-start;   /* 🔥 YE ADD KARO */

}

/* Sidebar */
.filters {
 width: 250px;
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  height: fit-content;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  position: sticky;
  top: 20px;
}

.filter-group {
  margin-bottom: 20px;
      text-align: left;

}

.filter-group h4 {
margin-bottom: 10px;
    font-weight: bold;
}

.filter-group label {
  display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
    margin-bottom: 8px;
    cursor: pointer;
}

.main-footer {
  margin-top: auto;   /* 🔥 MOST IMPORTANT */
  width: 100%;
  background: #0f172a;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;   /* ✅ spacing inside, not outside */
}

.filters h3,
.filters h4 {
  color: #1a3d7c;
}

.filter-group input {
  margin: 0;
}


.filter-group span {
    text-align: left;
}

.filter-group input[type="checkbox"],
.filter-group input[type="radio"] {
 width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #2563eb; /* Blue color for checked state */
    margin: 0;
}

.filters input {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.filters ul {
  list-style: none;
  padding: 0;
}

.filters ul li {
  padding: 5px 0;
  color: #555;
}

/* Job Listing */
.job-listing {
  flex: 1;
  display: grid;
  grid-template-columns: repeat(2, 1fr);  /* 🔥 2 cards per row */
  gap: 20px;
    margin: 0;
      padding: 20px;


}

/* Job Card */
.job-card {
  background-color: #f3f6fb;
  border: 1px solid #1a3d7c;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.08);
}

/* Job Header */
.job-header {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 10px;
}

.company-logo {
  width: 52px;
  height: 52px;
  border-radius: 5px;
}

/* Company Info */
.job-company h3 {
  margin: 0;
  font-size: 18px;
  color: #1a3d7c;
}

.job-company p {
  margin: 0;
  font-size: 14px;
  color: #555;
}

/* Title */
.job-title h2 {
  margin: 10px 0 5px;
  font-size: 20px;
  color: #1a3d7c;
}

.job-title p {
  margin: 0;
  font-size: 14px;
  color: #777;
}

/* Description */
.job-description {
  margin: 10px 0;
  font-size: 15px;
  color: #333;
}

/* Footer */
.job-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.salary {
  font-weight: bold;
  color: #1a3d7c;
}

.skills span {
  background-color: #dde9ff;
  padding: 5px 10px;
  border-radius: 5px;
  margin-right: 5px;
  font-size: 13px;
  color: #1a3d7c;
}

/* Button */
.apply-btn {
  background-color: #1a3d7c;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
}

.apply-btn:hover {
  background-color: #16326a;
}

.no-jobs {
  text-align: center;
  margin-top: 60px;
  font-size: 20px;

}
.search-item {
  display: flex;
  align-items: center;
  gap: 8px;
  flex: 1;
}

.filter-btn {
  width: 100%;
  padding: 10px;
  background: #0049af;
  color: white;
  border: none;
  border-radius: 6px;
  margin-top: 10px;
  cursor: pointer;
}

.clear-btn {
  display: block;
  text-align: center;
  margin-top: 10px;
  color: red;
  text-decoration: none;
}

.new-gif{
  width: 40px;
  height: 40px;
  position: absolute;
  top: 10px;
  right: 10px;
}
    </style>