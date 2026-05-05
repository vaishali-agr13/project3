<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;   // ✅ required
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    public function dashboard()
    {

            $userId = auth()->id();

            $appliedCount = Application::where('user_id', $userId)->count();

            $applications = Application::with('job')
                ->where('user_id', $userId)
                ->latest()
                ->get();

            // simple logic for profile %
            $profileComplete = 70; // abhi static, baad me dynamic karenge

            return view('candidate.dashboard', compact(
                'appliedCount',
                'applications',
                'profileComplete'
            ));
        return view('candidate.dashboard');
    }

    public function showForm()
    {
        return view('auth.register');
    }


    public function candidateList(){
         // $candidates = User::where('role', 'candidate')->get();
         $candidates = User::with('profile')->where('role', 'candidate')->get();

          return view('candidate.index', compact('candidates'));
    }
     public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'candidate',
        ]);

        Mail::raw(
                        "Welcome {$user->name},\n\nYour account has been created.\nEmail: {$user->email}\nPassword: {$request->password}",
                        function ($message) use ($user) {
                            $message->to($user->email)
                                    ->subject('Registration Successful');
                        }
                 );


        // auto login
        Auth::login($user);

        if (session()->has('pending_apply')) 
        {

           $data = session('pending_apply');

       

              // application save
                Application::create([
                    'job_id' => $data['job_id'],
                    'full_name' =>$user->name,
                    'email' =>   $user->email,
                    'resume' => $data['resume'],
                    'user_id' => $user->id,
                    'phone'=>$data['phone'],
                    'cover_letter' => $data['cover_letter'],
                ]);


                CandidateProfile::updateOrCreate(
                    ['user_id' => $user->id],   // match condition
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'resume' => $data['resume'], 
                        'phone'=>$data['phone'], 
                        // agar profile me resume store karna hai
                    ]
                );

            session()->forget('pending_apply');

            return redirect()->route('candidate.profile')->with('success', 'Job applied successfully!');

            // return redirect('/jobs/'.$data['job_id'])
            //     ->with('success', 'Application submitted successfully!');
        }

        CandidateProfile::updateOrCreate(
                    ['user_id' => $user->id],   // match condition
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
        );


        return redirect('/')
            ->with('success', 'Registration successful!');

    }


     public function index()
    {
        $profile = CandidateProfile::where('user_id', auth()->id())->first();
        return view('candidate.profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'skills' => 'required',
            'experience' => 'required',
            'education' => 'required',
            'name'=>'required',
            'profile_photo'=>'required',
            'email'=>'required',
             'resume' => 'nullable|mimes:pdf|max:2048',
            'portfolio'=>'required',
        ]);


        $resumePath = $request->old_resume;

            if ($request->hasFile('resume')) {

                // optional: purani file delete (safe cleanup)
                if ($request->old_resume && file_exists(storage_path('app/public/' . $request->old_resume))) {
                    unlink(storage_path('app/public/' . $request->old_resume));
                }

                $file = $request->file('resume');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $resumePath = $file->storeAs('resumes', $fileName, 'public');
            }

        $profile = CandidateProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [    
                'name' => $request->name,
                'email' => $request->email,
                'profile_photo' => $request->profile_photo,
                'portfolio' => $request->portfolio,
                'resume' => $resumePath,
                'phone' => $request->phone,
                'skills' => $request->skills,
                'experience' => $request->experience,
                'education' => $request->education,
            ]
        );
         return redirect('/candidate/jobs')->with('success', 'Profile saved successfully!');
      //  return back()->with('success', 'Profile updated successfully');
    }


}