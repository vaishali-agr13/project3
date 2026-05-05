@extends('layouts.app')

@section('content')

<div class="hero">
    <div class="category-icon">
              <i class="fas {{ !empty($category->icon) ? $category->icon : 'fa-folder' }}"></i>
    </div>
    <h1>{{ $category->name }}</h1>
    <p>{!! $category->description !!}</p>
</div>

<section class="section">


    <div class="grid">
        @foreach($category->jobs as $job)
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
        @endforeach
    </div>
</section>

@endsection


<style>

    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5f7fb;
}

/* HERO */
.hero {
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center mein alignment */
    align-items: flex-start; /* Left side mein aligned rakhega */
    text-align: left;
}

.hero h1 {
    font-weight:700;
    font-size: 36px;
    margin: 0;
}

.job-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}



/* tablet */
@media (max-width: 992px) {
    .job-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* mobile */
@media (max-width: 600px) {
    .job-grid {
        grid-template-columns: 1fr;
    }
}

.hero p {
    font-size: 18px;
    margin-top: 10px;
}

/* CONTAINER (FIXED) */
.job-container {
    width: 100%;
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
     max-width: 1200px; /* ya 1300px */
       display: block;   /* ✅ flex hatao */

}

/* JOB CARD (FIXED FLEX ISSUE) */
.job-card {
      position: relative;

    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;

    background: #f9fbff;
    border: 1px solid #e3e8f0;
    border-radius: 12px;

    padding: 20px;
    padding-right: 60px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.job-card:hover {
    transform: translateY(-3px);
}

/* LEFT */
.job-left {
    display: flex;
    flex-direction: column;
}

/* TOP ROW */
.job-top {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* LOGO */
.company-logo {
    position: absolute;
  top: 10px;
  right: 10px;
  width: 40px;   /* size adjust kar sakti ho */
  height: 40px;
  object-fit: contain;
}

/* COMPANY INFO */
.company-info h4 {
    margin: 0;
    font-size: 15px;
}

.company-info p {
    margin: 0;
    font-size: 12px;
    color: #666;
}

/* TITLE */
.job-title {
    margin: 10px 0 5px;
    font-size: 20px;
}

/* META */
.meta {
    display: flex;
    gap: 15px;
    font-size: 13px;
    color: #64748b;
}

/* DESCRIPTION */
.desc {
    font-size: 14px;
    color: #555;
    margin: 8px 0;
}

/* SALARY */
.salary {
    font-size: 18px;
    color: #2563eb;
}

.salary span {
    font-size: 14px;
    color: #666;
}   

</style>