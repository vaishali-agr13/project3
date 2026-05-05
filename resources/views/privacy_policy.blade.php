@extends('layouts.app')

@section('content')

<section class="py-16 bg-gray-50">
  <div class="max-w-5xl mx-auto px-4">

    <!-- 🔹 HEADER -->
    <div class="text-center mb-12">
      <h2 class="text-4xl font-bold blue-700 mb-4">Privacy Policy</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your personal information when you use our job portal.
      </p>
    </div>

    <!-- 🔹 CARD SECTIONS -->
    <div class="space-y-8">

      <!-- 1 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">1. Information We Collect</h3>
        <p class="text-gray-600 mb-2">
          We collect information to provide better services to all our users. This may include:
        </p>
        <ul class="list-disc pl-5 text-gray-600 text-sm space-y-1">
          <li>Personal details (name, email, phone number)</li>
          <li>Profile information (resume, skills, experience)</li>
          <li>Usage data (pages visited, interactions)</li>
        </ul>
      </div>

      <!-- 2 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">2. How We Use Your Information</h3>
        <p class="text-gray-600">
          Your information helps us improve our platform and provide a better experience. We may use your data to:
        </p>
        <ul class="list-disc pl-5 text-gray-600 text-sm mt-2 space-y-1">
          <li>Connect job seekers with recruiters</li>
          <li>Improve website performance and features</li>
          <li>Send updates, job alerts, and notifications</li>
        </ul>
      </div>

      <!-- 3 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">3. Data Protection</h3>
        <p class="text-gray-600">
          We take appropriate security measures to protect your data from unauthorized access, alteration, or disclosure. Your data is stored securely and only accessible to authorized personnel.
        </p>
      </div>

      <!-- 4 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">4. Sharing of Information</h3>
        <p class="text-gray-600">
          We do not sell your personal information. However, we may share limited data with trusted employers or service providers strictly for job-related purposes.
        </p>
      </div>

      <!-- 5 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">5. Cookies & Tracking</h3>
        <p class="text-gray-600">
          We use cookies to enhance user experience, analyze traffic, and personalize content. You can control cookie preferences through your browser settings.
        </p>
      </div>

      <!-- 6 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">6. Your Rights</h3>
        <p class="text-gray-600">
          You have the right to access, update, or delete your personal information. You may also opt out of communications at any time.
        </p>
      </div>

      <!-- 7 -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
        <h3 class="text-xl font-semibold blue-700 mb-3">7. Changes to Policy</h3>
        <p class="text-gray-600">
          We may update this Privacy Policy from time to time. Any changes will be posted on this page with updated revision dates.
        </p>
      </div>

    </div>

    <!-- 🔹 FOOTER NOTE -->
    <div class="text-center mt-12">
      <p class="text-gray-500 text-sm">
        If you have any questions about this Privacy Policy, please contact us.
      </p>
    </div>

  </div>
</section>

@endsection