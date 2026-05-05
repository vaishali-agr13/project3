@extends('layouts.app')

@section('content')

<!-- 🔹 SECTION 1: ABOUT INTRO -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
    <div>
      <h2 class="text-3xl font-bold mb-4">About Us</h2>
      <p class="text-gray-600 mb-4">
        We are a modern digital platform focused on connecting users with the best opportunities. Our mission is to simplify access to jobs, services, and professional growth.
      </p>
      <p class="text-gray-600">
        With a user-friendly interface and powerful backend system, we ensure seamless experience for both job seekers and recruiters.
      </p>
    </div>
    <div>
      <img src="{{ asset('images/about.jpg') }}" class="rounded-2xl shadow-lg about-image">
    </div>
  </div>
</section>

<!-- 🔹 SECTION 2: OUR FEATURES -->
<section class="py-16 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold mb-10">Why Choose Us</h2>

    <div class="grid md:grid-cols-3 gap-8">
      
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="text-purple-600 text-4xl mb-4">💼</div>
        <h3 class="font-semibold text-lg mb-2">Verified Jobs</h3>
        <p class="text-gray-600 text-sm">We provide trusted and verified job listings from top companies.</p>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="text-purple-600 text-4xl mb-4">⚡</div>
        <h3 class="font-semibold text-lg mb-2">Fast Process</h3>
        <p class="text-gray-600 text-sm">Apply to jobs quickly with our smooth and fast platform.</p>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <div class="text-purple-600 text-4xl mb-4">📈</div>
        <h3 class="font-semibold text-lg mb-2">Career Growth</h3>
        <p class="text-gray-600 text-sm">Helping you grow your career with better opportunities.</p>
      </div>

    </div>
  </div>
</section>

<!-- 🔹 SECTION 3: OUR MISSION & VISION -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10">

    <div class="bg-purple-50 p-8 rounded-2xl shadow">
      <h3 class="text-2xl font-semibold mb-4">Our Mission</h3>
      <p class="text-gray-600">
        Our mission is to bridge the gap between talent and opportunity by providing a reliable and easy-to-use platform for job seekers and employers.
      </p>
    </div>

    <div class="bg-purple-50 p-8 rounded-2xl shadow">
      <h3 class="text-2xl font-semibold  mb-4">Our Vision</h3>
      <p class="text-gray-600">
        We aim to become a leading job platform that empowers millions of users to achieve their professional goals.
      </p>
    </div>

  </div>
</section>

<!-- 🔹 SECTION 4: CALL TO ACTION -->
<section class="py-16 blue-700 text-white text-center">
  <div class="max-w-4xl mx-auto px-4">
    <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
    <p class="mb-6 text-purple-100">Join our platform today and explore thousands of job opportunities.</p>
    
    <a href="/" style="color:black;" class="bg-white blue-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
      Browse Jobs
    </a>
  </div>
</section>

@endsection