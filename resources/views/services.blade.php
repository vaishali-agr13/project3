@extends('layouts.app')

@section('content')
<section id="services" class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold blue-700 mb-10">Our Services</h2>
    <div class="grid md:grid-cols-3 gap-8">

      <div class="p-6 bg-gray-50 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl blue-700 font-semibold mb-2 ">Job Listings</h3>
        <p class="text-gray-600">Browse and apply for latest job opportunities easily.</p>
      </div>

      <div class="p-6 bg-gray-50 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl blue-700 font-semibold mb-2">Recruitment</h3>
        <p class="text-gray-600">Employers can post jobs and find the best candidates.</p>
      </div>

      <div class="p-6 bg-gray-50 rounded-2xl shadow hover:shadow-lg transition">
        <h3 class="text-xl blue-700 font-semibold mb-2">Career Guidance</h3>
        <p class="text-gray-600">Get expert advice to grow your professional career.</p>
      </div>

    </div>
  </div>
</section>
@endsection