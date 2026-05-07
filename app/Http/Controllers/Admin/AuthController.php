<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;   // ✅ required
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\JobController;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }


    public function profile(){
         //$user = Auth::user();
        $profile = Profile::where('user_type','admin')->first();

        return view('auth.profile', compact('profile'));
    }

    public function updateProfile(Request $request, $id)
        {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            $profile = Profile::findOrFail($id);

            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'logo' => $request->logo,
                'user_type' => 'admin'
            ];


                if ($request->hasFile('logo')) {

                    // old logo delete (important)
                    if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                        Storage::disk('public')->delete($profile->logo);
                    }

                    // new logo upload
                    $data['logo'] = $request->file('logo')->store('profiles', 'public');
                }
            
            $profile->update($data);
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }


    public function storeProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'logo'  => 'nullable|image'
        ]);

        //$data = $request->all();

        $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'user_type' => 'admin' // 👈 fixed value
                ];

                //print_r($data);die;
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profiles', 'public');
        }

        Profile::create($data);

        return back()->with('success', 'Profile created successfully!');
    }

    public function loginAdmin(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'admin'
            ])) {

                $request->session()->regenerate();

                return redirect()->intended('admin/jobs/create');
            }

            return back()->with('error', 'Invalid admin credentials');
        }
//    public function login(Request $request)
//     {
//             $request->validate([
//                 'email' => 'required|email',
//                 'password' => 'required'
//             ]);

//             if (Auth::attempt($request->only('email', 'password'))) {

//                 $request->session()->regenerate(); // ✅ yaha hona chahiye

//                 $user = Auth::user();

//                 // 🔹 ADMIN LOGIN
//                 if ($user->role == 'admin') {
//                     return redirect()->intended('admin/jobs/create');
//                 }

//                 // 🔹 CANDIDATE LOGIN
//                 if ($user->role == 'candidate') {


//                     $profileExists = CandidateProfile::where('user_id', $user->id)->exists();

//                     if (!$profileExists) {
//                         CandidateProfile::create([
//                             'user_id' => $user->id,
//                             'name' => $user->name,
//                             'email' => $user->email,
//                         ]);
//                     }

//                     $data = session('pending_apply');


//                     if ($data) {
//                        $data['full_name'] =  $user->name;
//                        $data['email'] = $user->email;
//                         session()->forget('pending_apply');

//                         // 👉 JobController ka method call karo
//                         return app(JobController::class)
//                             ->storeApplicationFromLogin($data, $data['job_id']);
//                     }

//                     if($data){
//                         return redirect()->route('candidate.profile')->with('success', 'Job applied successfully!');

//                        //return redirect()->intended('/');
//                     }
//                     else {
//                         return redirect('/candidate/dashboard');
//                     }

                    
//                 }
//             }

//     return back()->with('error', 'Invalid credentials');
//    }


        public function loginCandidate(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'candidate'
            ])) {

                $request->session()->regenerate();

                $user = Auth::user();

                // 🔹 Profile create if not exists
                $profileExists = CandidateProfile::where('user_id', $user->id)->exists();

                if (!$profileExists) {
                    CandidateProfile::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]);
                }

                // 🔹 Pending job apply logic
                $data = session('pending_apply');

                if ($data) {
                    $data['full_name'] = $user->name;
                    $data['email'] = $user->email;

                    session()->forget('pending_apply');

                    return app(JobController::class)
                        ->storeApplicationFromLogin($data, $data['job_id']);
                }

                // 🔹 Normal redirect
                return redirect('/candidate/dashboard');
            }

            return back()->with('error', 'Invalid candidate credentials');
    }
    
    
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }

    

    public function showCanddiateLogin()
    {
        return view('auth.login');
    }

       public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/reset-password/'.$token.'?email='.$request->email);

        Mail::raw("Click here to reset password: ".$resetLink, function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password');
        });

        return back()->with('success', 'Reset link sent to your email.');
    }

    // Show reset password form
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $resetData = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Invalid reset request']);
        }

        // Check token
        if (!Hash::check($request->token, $resetData->token)) {
            return back()->withErrors(['token' => 'Invalid token']);
        }

        // Update password
        $updated = User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);


        // Delete token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/candidate/login')->with('success', 'Password reset successful.');
    }

}