@extends('layouts.app')

@section('content') 
            <div class="w-full flex justify-center px-4">
                <div class="w-full max-w-lg">
                        <div id="applyForm" class=" mt-4 bg-white p-6 rounded-xl shadow-md border-t-4 custom-border">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Apply Now</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-4 text-sm font-medium">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="full_name"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="John Doe" required>                       
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="john@example.com" required>                        
                        </div>

                         <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                            <input type="number" name="phone"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Enter Phone No" required>                        
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Resume (PDF)</label>
                            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center hover:border-blue-500 transition cursor-pointer">
                                <input type="file" name="resume" accept=".pdf" class="hidden" id="resumeUpload" required>
                                <p id="file-name"></p>

                                <label for="resumeUpload" class="cursor-pointer text-gray-500">
                                    <i class="fas fa-cloud-upload-alt text-2xl mb-2 block"></i>
                                    <span class="text-sm">Click to upload PDF</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Cover Letter (Optional)</label>
                            <textarea name="cover_letter" rows="3"
                            class="w-full px-4 py-2 border rounded-lg text-gray-900 bg-white focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Why are you a good fit?"></textarea>                        
                        </div>

                        <button type="submit" class="w-full text-white font-bold submit-btn py-3 rounded-lg hover:bg-lime-600 shadow-lg transform active:scale-95 transition duration-200">
                            Submit Application
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 mt-4 text-center">
                        By clicking Apply, you agree to our Terms of Service.
                    </p>
                </div>
            </div>
        </div>


            <script>
document.addEventListener('DOMContentLoaded', function () {
 console.log('event outside');
    const input = document.getElementById('resumeUpload');
    const fileText = document.getElementById('file-name');

    input.addEventListener('change', function(e) {
        console.log('event inside');
        fileText.innerText = e.target.files.length > 0 
            ? e.target.files[0].name 
            : 'No file selected';
    });

});

</script>

            @endsection