
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Portal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body class="bg-[#0f172a] text-white">

  <!-- Navbar -->

  <!-- TOP HEADER -->
<div class="top-header">
  
  <!-- LEFT: SOCIAL MEDIA -->
  <div class="top-left" style="margin-left:-23px;">
    <a href="https://www.facebook.com/share/1AjicM8ZoD"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
    <a href="https://www.linkedin.com"><i class="fa-brands fa-linkedin-in"></i></a>
    <a href="https://www.instagram.com/rjindiajobs?utm_source=qr&igsh=MWpxZTd2aGc3YTk1ZA=="><i class="fa-brands fa-instagram"></i></a>
  </div>

  <!-- RIGHT: CONTACT INFO -->
  <div class="top-right">
    <span>
      <a href="https://wa.me/919039023534" target="_blank">
           <i class="fa-brands fa-whatsapp"></i> 
           {{ $profile->phone ?? '+91 9039023534' }}
           
      </a>
     </span>
    <span>
       <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@rjindiajobs.com" target="_blank">
           <i class="fa-regular fa-envelope"></i>  {{ $profile->email ?? 'info@rjindiajobs.com ' }}
       </a>
    </span>
  </div>

</div>

  <header class="flex justify-between items-center px-6 py-3">
  
  <!-- Logo -->
  <h1 class="text-white" style="color:black;">
    <a href="/">
        <img src="{{ asset('images/company-logo.png') }}"  class="company_logo"  alt="Resume Tips">

            <div class="flex flex-col leading-tight">
                <span class="font-bold text-[#0049af] text-lg">
               FK Strategy
                </span>
               
          </div>
    </a>
  </h1>

  <!-- Menu -->
  <nav class="flex items-center justify-between" style="color:black;">
    <div class="hidden md:flex items-center gap-6" style="color:black;">

        <a href="/" class="hover:text-blue-400"><i class="fa-solid fa-house"></i></a>
        <a href="/about" class="hover:text-blue-400">About</a>
        <a href="/find-jobs" class="hover:text-blue-400">Find a Job</a>
        <a href="/companies" class="hover:text-blue-400">Post Job</a>
    
    <!-- <a href="/services" class="hover:text-blue-400">Services</a>
    <a href="/privacy-policy" class="hover:text-blue-400">Privacy Policy</a> -->
     <div class="relative inline-block text-left" x-data="{ open: false }">
    
    <button @click="open = !open" @click.away="open = false" 
            class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
        
        <div class="py-1">



            @if(auth()->check())
                 <a href="/admin/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                      <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                      </svg>
                      Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                  </form>

            @else
                <a href="/candidate/login" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                </a>

                <a href="/candidate/register" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Sign Up
                </a>
            @endif
            
          @auth
              @if(auth()->user()->role === 'candidate')
                    <a href="/candidate/dashboard" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Dashboard
                    </a>
              @endif
          @endauth
        </div>
       </div>
     
      </div>
    </div>

    <div class="md:hidden" x-data="{ openMenu: false }">
        
        <button @click="openMenu = !openMenu" class="p-2">
            <i class="fas fa-ellipsis-v text-xl"></i>
        </button>

        <div x-show="openMenu" @click.away="openMenu = false"
             class="absolute right-4 mt-2 w-48 bg-white shadow-lg rounded-md z-50">

            <a href="/" class="block px-4 py-2 hover:bg-gray-100">Home</a>
            <a href="/about" class="block px-4 py-2 hover:bg-gray-100">About</a>
            <a href="/find-jobs" class="block px-4 py-2 hover:bg-gray-100">Find a Job</a>
            <a href="/companies" class="block px-4 py-2 hover:bg-gray-100">Post Job</a>

            @if(auth()->check() && auth()->user()->role === 'candidate')
                <a href="/candidate/dashboard" class="block px-4 py-2 hover:bg-gray-100">
                    Dashboard
                </a>
            @endif

            @if(auth()->check())
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="block px-4 py-2 hover:bg-gray-100">Logout</a>
            @else
                <a href="/candidate/login" class="block px-4 py-2 hover:bg-gray-100">Login</a>
                <a href="/candidate/register" class="block px-4 py-2 hover:bg-gray-100">Sign Up</a>
            @endif
        </div>
    </div>
    <!-- <a href="/admin/login" class="hover:text-blue-400">Login</a> -->
  </nav>

</header>

  @yield('content')

  <!-- Footer -->
  <footer class="main-footer">

  <div class="footer-container">

    <!-- COLUMN 1 -->
    <div class="footer-col">
      <img src="{{ asset('images/company-logo.png') }}"  class="company_logo"  alt="Resume Tips">
      <p>Find your dream job easily with thousands of opportunities from top companies.</p>
    </div>

    <!-- COLUMN 2 -->
    <div class="footer-col">
      <h5>Quick Links</h5>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/find-jobs">Find Jobs</a></li>
        <li><a href="#">Companies</a></li>
      </ul>
    </div>

    <!-- COLUMN 3 -->
    <div class="footer-col">
     <h5></h5>
      <ul>
        <li><a href="/about">About</a></li>
        <li><a href="/services">Services</a></li>
        <li><a href="/privacy-policy">Privacy Policy</a></li>
      </ul>
    </div>

    <!-- COLUMN 4 -->
    <div class="footer-col">
      <h5>Contact</h5>
      <p> <a href="https://wa.me/919039023534" target="_blank">
           <i class="fa-brands fa-whatsapp"></i> {{ $profile->phone ?? '+91 9039023534' }}
          </a>
      </p>
      <p>
         <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@rjindiajobs.com" target="_blank">
           <i class="fa-regular fa-envelope"></i>  {{ $profile->email ?? 'info@rjindiajobs.com ' }}
         </a>
      </p>

      <div class="footer-social">
        <a href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="https://x.com/"><i class="fa-brands fa-twitter"></i></a>
      </div>
    </div>

  </div>

  <!-- BOTTOM BAR -->
  <div class="footer-bottom">
    <p>© 2026 JobPortal. All rights reserved.</p>
  </div>


  <script>

 document.addEventListener("keydown", function(e) {
  if (e.ctrlKey || e.metaKey) {
    // keyCode: 187 (=,+), 189 (-,_)
    if (e.keyCode === 187 || e.keyCode === 189) {
      e.preventDefault();
      document.body.style.zoom = "100%";
    }
  }
});

// Disable Ctrl + scroll zoom
window.addEventListener("wheel", function(e) {
  if (e.ctrlKey) {
    e.preventDefault();
  }
}, { passive: false });
</script>

</footer>

</body>
</html>