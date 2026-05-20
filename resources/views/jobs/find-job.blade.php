<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@extends('layouts.app')
@section('content')
<main>
<div class="jobs-hero">
  <div class="hero-content header-text">
    <h1>The official <span class="highlight">IT Jobs</span> site</h1>
    <p>“JobBox is our first stop whenever we're hiring a PHP role. We've hired 10 PHP developers in the last few years, all thanks to JobBox.” — Andrew Hall, Elite JSC.</p>
  </div>
        <form action="{{ url('/find-jobs') }}" method="GET">
                           
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

              <div class="search-item relative" x-data="{ open: false, selected: '{{ request('category') ?? '' }}' }">
    
                <div @click="open = !open" class="category-text flex items-center cursor-pointer space-x-3 min-w-[180px]">
                    
                    <div class="text-xl">📂</div>
                    
                    <div class="flex flex-col overflow-hidden">
                        <template x-if="selected !== ''">
                            <span class="text-[9px] text-blue-500 font-bold uppercase leading-none mb-1">
                                Category
                            </span>
                        </template>

                         <span style="font-size:15px; line-height:1;" class="text-[9px] leading-none font-normal text-gray-400 truncate"
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
  <div class="categories-container">
    <div class="swiper categorySwiper">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
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
        
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="jobs-page">

<button class="filter-toggle" onclick="toggleFilters()">
  ☰ Filters
</button>

  <aside class="filters">

      <button onclick="toggleFilters()" class="close-filter-btn" style="float:right; font-size:18px; border:none; background:none; cursor:pointer;">
       ✖
    </button>

    <form method="GET" action="{{ url('/find-jobs') }}" id="filterForm">

      <div class="filter-header">
        <h3>Filters</h3>
      </div>

      <div class="filter-group">
        <h4>Job Type</h4>
        <label class="filter-option">
          <input type="checkbox" name="job_type[]" value="Full-Time"
          {{ in_array('Full-Time', request('job_type', [])) ? 'checked' : '' }}>
         <span>Full Time</span>
        </label>

        <label class="filter-option">
          <input type="checkbox" name="job_type[]" value="Part-Time"
          {{ in_array('Part-Time', request('job_type', [])) ? 'checked' : '' }}>
          <span>Part Time</span>
        </label>
      </div>

      <div class="filter-group">
        <h4>Location</h4>

          @foreach($districts as $district)
            <label class="filter-option">
              <input type="checkbox" name="locations[]" value="{{$district}}"
              {{ in_array($district, request('locations', [])) ? 'checked' : '' }}>
              <span>{{$district}}</span>
            </label>
          @endforeach


        <!-- <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Delhi"
          {{ in_array('Delhi', request('locations', [])) ? 'checked' : '' }}>
          <span>Delhi</span>
        </label>

        <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Mumbai"
          {{ in_array('Mumbai', request('locations', [])) ? 'checked' : '' }}>
        <span>Mumbai</span>
        </label>

         <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Pune"
          {{ in_array('Pune', request('locations', [])) ? 'checked' : '' }}>
          <span>Pune</span>
        </label>
        <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Hyderabad"
          {{ in_array('Hyderabad', request('locations', [])) ? 'checked' : '' }}>
          <span>Hyderabad</span>
        </label>
        <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Noida"
          {{ in_array('Noida', request('locations', [])) ? 'checked' : '' }}>
          <span>Noida</span>
        </label>

         <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Bengaluru"
          {{ in_array('Bengaluru', request('locations', [])) ? 'checked' : '' }}>
          <span>Bengaluru</span>
        </label>

         <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Indore"
          {{ in_array('Indore', request('locations', [])) ? 'checked' : '' }}>
          <span>Indore</span>
        </label>
        
         <label class="filter-option">
          <input type="checkbox" name="locations[]" value="Bhopal"
          {{ in_array('Bhopal', request('locations', [])) ? 'checked' : '' }}>
          <span>Bhopal</span>
        </label> -->
      </div>

      <div class="filter-group">
        <h4>Salary</h4>
        <label class="filter-option">
          <input type="radio" name="salary" value="0-3"
          {{ request('salary') == '0-3' ? 'checked' : '' }}>
          <span>0-3 LPA</span>
        </label>

        <label class="filter-option">
          <input type="radio" name="salary" value="3-6"
          {{ request('salary') == '3-6' ? 'checked' : '' }}>
         <span>3-6 LPA</span>
        </label>
        <label class="filter-option">
          <input type="radio" name="salary" value="6-10"
          {{ request('salary') == '6-10' ? 'checked' : '' }}>
         <span>6-10 LPA</span>
        </label>
        <label class="filter-option">
          <input type="radio" name="salary" value="10-15"
          {{ request('salary') == '10-15' ? 'checked' : '' }}>
         <span>10-15 LPA</span>
        </label>
      </div>

      <div class="filter-group">
          <h4>Experience</h4>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="Fresher"
              {{ in_array('Fresher', request('experience', [])) ? 'checked' : '' }}>
              <span>Fresher</span>
          </label>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="Less than 1 years"
              {{ in_array('Less than 1 years', request('experience', [])) ? 'checked' : '' }}>
              <span>Less than 1 years</span>
          </label>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="Less than 2 years"
              {{ in_array('Less than 2 years', request('experience', [])) ? 'checked' : '' }}>
              <span>Less than 2 years</span>
          </label>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="Less than 3 years"
              {{ in_array('Less than 3 years', request('experience', [])) ? 'checked' : '' }}>
              <span>Less than 3 years</span>
          </label>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="Less than 4 years"
              {{ in_array('Less than 4 years', request('experience', [])) ? 'checked' : '' }}>
              <span>Less than 4 years</span>
          </label>

          <label class="filter-option">
              <input type="checkbox" name="experience[]" value="More than 4 years"
              {{ in_array('More than 4 years', request('experience', [])) ? 'checked' : '' }}>
              <span>More than 4 years</span>
          </label>
      </div>

      <button type="submit" class="filter-btn">Apply Filters</button>
      <a href="{{ url('/find-jobs') }}" class="clear-btn">Clear All</a>
    </form>

  </aside>
<div class="overlay" onclick="toggleFilters()"></div>

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
                    {{ \Illuminate\Support\Str::limit($job->district, 10, '...') }}
                  </p>
                </div>
              </div>

              <div class="job-title">
                <h2>{{$job->title}}</h2>
                <p>{{$job->job_type}} </p>
              </div>

              <div class="job-description">
                {{$job->experience}}
              <!-- {!! Str::limit(strip_tags($job->description), 120) !!} -->
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
            breakpoints: {
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
                1280: { slidesPerView: 5 }
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
.search-item span { font-size: 18px !important; }

.category-text span {
    font-size: 14px !important;
    font-weight: 400 !important;
}

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
  margin-bottom: 0 !important;
}

/* Page Layout Fix */
.jobs-page {
  display: flex;
  gap: 30px;
  min-height: 80vh;
  align-items: flex-start;
  max-width: 1300px;
  margin: 0 auto;
  padding: 20px;
  width: 100%;
  box-sizing: border-box;
}

/* Sidebar Responsive Fix */
.filters {
  width: 280px;
  flex-shrink: 0; /* Sidebar compress nahi hoga */
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  height: fit-content;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  position: sticky;
  top: 20px;
  border: 1px solid #eee;
  box-sizing: border-box;
}

.close-filter-btn {
  display: none; /* Desktop par cross button hidden */
}

/* Right Content Area */
.job-listing {
  flex-grow: 1; /* Bache hue saare space ko cover karega */
  width: 100%;
}

/* Auto Responsive Grid Fix */
.job-container {
  display: grid !important;
  /* Auto-fill aur minmax cards ko hamesha minimum 260px aur maximum space available me wrap karega */
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important;
  gap: 20px;
  width: 100%;
}

.job-card {
  min-width: 0;
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.03);
  border: 1px solid #f0f0f0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

/* Purani width aur column definitions ko hatakar clean responsive approach */
@media (max-width: 992px) {
  .job-container {
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)) !important;
  }
}

/* Mobile Filter Drawer View Toggle */
@media (max-width: 768px) {
  .filters {
    position: fixed;
    left: -320px;
    top: 0;
    height: 100vh;
    z-index: 999;
    transition: left 0.3s ease;
    width: 300px;
  }
  .filters.active {
    left: 0;
  }
  .close-filter-btn {
    display: block;
  }
  .filter-toggle {
    display: block !important;
  }
}

.jobs-hero {
  background-color: #e7f3fd;
  padding: 60px 20px;
  text-align: center;
  color: #00395b;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 30px;
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
  height: 40px;
  padding: 0 10px;
  border: none;
  outline: none;
  font-size: 14px;
  color: #000;
  background: transparent;
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

.swiper-pagination-bullet-active {
        background: #0049af !important;
    }
    
.swiper-pagination {
    position: relative !important;
    margin-top: 30px !important;
}

.categories-container {
        padding: 40px 0;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
}

.apply-btn:hover {
  background-color: #16326a;
}

.search-item {
  display: flex;
  align-items: center;
  gap: 8px;
  flex: 1;
}

.filter-btn {
  width:100%;
  padding:10px;
  background:#0049af;
  border:none;
  color:#fff;
  border-radius:8px;
  font-weight:bold;
  margin-top:10px;
}

.clear-btn {
  display:block;
  text-align:center;
  margin-top:8px;
  font-size:13px;
  color:#666;
}

.filter-group{
  padding:12px 0;
  border-top:1px solid #f1f1f1;
}

.filter-header h3{
  font-size:16px;
  margin:0;
}

/* Margin-left negative fix to prevent bad alignment */
.filter-group h4{
  font-size:13px;
  font-weight: 700;
  margin-bottom:8px;
  color:#333;
  text-align: left;
}

.filter-option{
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  margin: 6px 0;
  cursor: pointer;
  justify-content: flex-start;
  text-align: left;
  width: 100%;
}

.filter-option span{
  text-align: left !important;
  display: inline-block;
  flex: 1;
}
.filter-option input{
  accent-color:#ff5a3c;
}

.new-gif{
  width: 40px;
  height: 40px;
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>