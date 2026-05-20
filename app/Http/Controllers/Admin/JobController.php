<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job; 
use App\Models\User;
use App\Notifications\AdminNotification; 
use App\Models\Application;
use App\Models\Category;
use App\Mail\ApplicationStatusMail;
use App\Mail\JobPostedMail;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Mail;
// Model ko import karna na bhoolein

class JobController extends Controller
{

      public function index()
        {
            $query = Job::where(function ($q) {
                $q->where('posted_by_type', 'admin')
                ->orWhere(function ($q2) {
                    $q2->where('posted_by_type', 'company')
                        ->where('approval_status', 'approved');
                });
            });

            $jobs = $query->with('categoryData')->latest()->get();

            return view('admin.jobs.index', compact('jobs'));
        }
    public function create()
    {
        $categories = Category::all();
        return view('admin.jobs.create', compact('categories'));
    }


    public function edit($id, Request $request)
    {
        $job = Job::find($id);
        $categories = Category::all();
        if (!$job) {
          return redirect()->back()->with('error', 'Job not found');
        }

         $from = $request->from;

        return view('admin.jobs.edit', compact('job', 'categories','from'));
    }



        public function export(Request $request)
        {
            $query = Application::with('job');

            // 🔹 Role logic
            if (auth()->user()->role !== 'admin') {
                $query->where('user_id', auth()->id());
            }

            // 🔍 Title filter
            if ($request->filled('title')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->title . '%');
                });
            }

                // 📅 Date filter
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

                // 👤 Name search
            if ($request->filled('name')) {
                $query->where('full_name', 'like', '%' . $request->name . '%');
            }

            // 📱 Mobile search
            if ($request->filled('mobile')) {
                $query->where('phone', 'like', '%' . $request->mobile . '%');
            }

            $applications = $query->latest()->get();

            // PDF view load
            $pdf = Pdf::loadView('admin.applications.pdf', compact('applications'));

            return $pdf->download('applications.pdf');
        }


    public function update(Request $request, $id)
    {
        $job = Job::find($id);

        
        $salaryMin = is_numeric(str_replace(',', '', $request->salary_min))
            ? (float) str_replace(',', '', $request->salary_min)
            : null;

        $salaryMax = is_numeric(str_replace(',', '', $request->salary_max))
            ? (float) str_replace(',', '', $request->salary_max)
            : null;
    

        $data['salary_min'] = $request->salary_min
            ? (int) str_replace(',', '', $request->salary_min)
            : null;

        $data['salary_max'] = $request->salary_max
            ? (int) str_replace(',', '', $request->salary_max)
            : null;

        $job->update([
            'title' => $request->title,
            'category' => $request->category, // tumhara column name
            'company_name' => $request->company_name,
            'location' => $request->location,
            'company_email' => $request->company_email,
            'salary_min' => $data['salary_min'] ,
            'salary_max' =>  $data['salary_max'],
            'experience' => $request->experience,
            'description' => $request->description,
            'job_type' => $request->job_type,
            'status' => $request->status,
            'skills_required'=>$request->skills_required,
            'who_can_apply'=>$request->who_can_apply,
            'roles_responsibility'=>$request->roles_responsibility,
            'no_of_openings'=>$request->no_of_openings,

            /*'posted_by_type'=>$request->posted_by_type,*/
        ]);

        if($request->from=='company'){
             return redirect('/admin/companies/jobs')->with('success', 'Job updated successfully');
        }
        else if ($request->from=='jobs'){
            return redirect()->route('jobs.index')->with('success', 'Job Updated Successfully');
        }
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        $job->delete();
        return redirect('/admin/companies/jobs')->with('success', 'Job Deleted Successfully');
        //return redirect()->route('/companies/jobs')->with('success', 'Job Deleted Successfully');
    }


    public function applyForm($id){
            $job = Job::with('categoryData')->find($id);
            return view('jobs.apply-job', compact('job'));
    }

    public function updateApplicationStatus(Request $request, $id)
        {
            $application = Application::find($id);

            // validate status
            $request->validate([
                'status' => 'required|in:approved,rejected'
            ]);

            $application->status = $request->status;
            $application->save();

            Mail::to($application->email)->send(new ApplicationStatusMail($application));

            return redirect()->back()->with('success', 'Status updated successfully');
        }

    public function store(Request $request)
    {

        // 1. Data Validate karein
        $data = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'description' => 'required',
            'location' => 'required',
            'salary_min' => 'nullable',
            'salary_max' => 'nullable',
            'company_name' => 'nullable',
            'company_email' => 'nullable',
            'experience' => 'required', // Isse mandatory banaya hai
             'posted_by_type' => 'required'  ,
             'who_can_apply'=>'required',
             'no_of_openings'=>'required'
        ]);


        $salaryMin = is_numeric(str_replace(',', '', $request->salary_min))
            ? (float) str_replace(',', '', $request->salary_min)
            : null;

        $salaryMax = is_numeric(str_replace(',', '', $request->salary_max))
            ? (float) str_replace(',', '', $request->salary_max)
            : null;
        // 2. Database mein save karein
        $data = $request->all();

        $data['salary_min'] = $request->salary_min
            ? (int) str_replace(',', '', $request->salary_min)
            : null;

        $data['salary_max'] = $request->salary_max
            ? (int) str_replace(',', '', $request->salary_max)
            : null;

        $job = Job::create($data);
        

        if ($request->posted_by_type == 'admin') {
               $users = User::where('role', 'candidate')->get();
               $email = Auth::user()->email;
                foreach ($users as $user) {
                    $user->notify(new AdminNotification(
                        'New Job Posted: ' . $job->title
                    ));
                }
            Mail::to( $job->company_email)
               ->cc($email)
               ->send(new JobPostedMail($job));
            return redirect()->route('admin.jobs.create')->with('success', 'Job Successfully Posted');

        }
        else {
               Mail::to( $job->company_email)
                ->send(new JobPostedMail($job));

            

            return back()->with('success', 'Job posted successfully');
        }
    }

    public function applications(Request $request)
        {
            $query = Application::with('job');

            // 🔹 ROLE BASED DATA
            if (auth()->user()->role !== 'admin') {
                $query->where('user_id', auth()->id());
            }

            // 🔍 Title search (job title se)
            if ($request->filled('title')) {
                $query->whereHas('job', function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->title . '%');
                });
            }

            // 📅 Date filter (application date)
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }


                // 👤 Name search
                if ($request->filled('name')) {
                    $query->where('full_name', 'like', '%' . $request->name . '%');
                }

                // 📱 Mobile search
                if ($request->filled('mobile')) {
                    $query->where('phone', 'like', '%' . $request->mobile . '%');
                }
            $applications = $query->latest()->get();

            return view('admin.applications.index', compact('applications'));
        }


    public function apply(Request $request, $id)
        {
                // 🔐 Step 1: Validation
                $request->validate([
                    'full_name' => 'required|string|max:255',
                    'email' => 'required_if:guest,true|email',
                    'resume' => 'required|mimes:pdf|max:2048',
                    'phone' => 'required|string|max:20',
                    'cover_letter' => 'nullable|string',
                ]);

                // 📄 Step 2: Resume Upload
                $filePath = null;

                if ($request->hasFile('resume')) {
                    $fileName = time() . '_' . $request->file('resume')->getClientOriginalName();
                    $filePath = $request->file('resume')->storeAs('resumes', $fileName, 'public');
                }

                // 👤 Step 3: Not logged in → store session & redirect to register
                if (!auth()->check()) {

                    session()->put('pending_apply', [
                        'job_id' => $id,
                        'full_name' => $request->full_name,
                        'email' => $request->email,
                        'cover_letter' => $request->cover_letter,
                        'phone' => $request->phone,
                        'resume' => $filePath,
                    ]);

                    return redirect()->route('register');
                }

                // 👮 Step 4: If ADMIN is logged in → logout & send to register
                $user = auth()->user();

                if ($user->role === 'admin') {

                    auth()->logout();
                    request()->session()->invalidate();
                    request()->session()->regenerateToken();

                    session()->put('pending_apply', [
                        'job_id' => $id,
                        'full_name' => $request->full_name,
                        'email' => $request->email,
                        'cover_letter' => $request->cover_letter,
                        'phone' => $request->phone,
                        'resume' => $filePath,
                    ]);

                    return redirect()->route('register')
                        ->with('error', 'Admin cannot apply for jobs. Please register as candidate.');
                }

                // 💾 Step 5: Save Application (Candidate only)
                Application::create([
                    'job_id' => $id,
                    'full_name' => $request->full_name,
                    'email' => $user->email,
                    'phone' => $request->phone,
                    'resume' => $filePath,
                    'user_id' => $user->id,
                    'cover_letter' => $request->cover_letter,
                ]);

                // 🧑‍💼 Step 6: Ensure role is candidate
                // if ($user->role !== 'candidate') {
                //     $user->role = 'candidate';
                //     $user->save();
                // }

                // 🔁 Step 7: Redirect based on role
                return redirect()
                    ->route('candidate.profile')
                    ->with('success', 'Job applied successfully!');
        }


        public function storeApplicationFromLogin($form, $jobId)
        {
            // resume remove karo validation se
            if (
                empty($form['full_name']) ||
                empty($form['email'])
            ) {
                return redirect('/jobs/'.$jobId)
                    ->with('error', 'Please fill all required fields.');
            }

            if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect('/jobs/'.$jobId)
                    ->with('error', 'Invalid email format.');
            }

            // ⚠️ resume yaha possible nahi hai
            // isliye null ya skip karo

            Application::create([
                'job_id' => $jobId,
                'full_name' => $form['full_name'],
                'email' => $form['email'],
                'resume' => $form['resume'], // important
                'user_id' => auth()->id(),
                'phone'=>$form['phone'],
                'cover_letter' => $form['cover_letter'] ?? null,
            ]);

            return redirect()->route('candidate.profile')->with('success', 'Job applied successfully!');

            // return redirect('/jobs/'.$jobId)
            //     ->with('success', 'Application submitted! Please upload resume.');
        }




        public function storeCompanyDetails(Request $request)
        {
            // ✅ Validation
            $request->validate([
                'company_name'  => 'required|string|max:255',
                'company_email' => 'required|email|max:255',
                'company_phone' => 'required|max:20',
                'website'       => 'nullable|max:255',
                'pincode'       => 'required|digits:6',
                'state'         => 'required|string|max:255',
                'district'      => 'required|string|max:255',
                'address'       => 'required|string',
            ]);

            // ✅ Save Company
            $company = Job::create([
                'user_id'       => auth()->id(),
                'company_name'  => $request->company_name,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'website'       => $request->website,
                'pincode'       => $request->pincode,
                'state'         => $request->state,
                'district'      => $request->district,
                'address'       => $request->address,
            ]);

            session(['job_id' => $company->id]);


            // ✅ Session for step 2
            return redirect()->back()->with('success', 'Company details saved successfully.')
                                     ->with('step', 2);
        }

    public function storeJobByCompany(Request $request)
    { 
        $jobId = session('job_id');
        $job = Job::find($jobId);

        $email = $job->company_email;

        $data['salary_min'] = $request->salary_min
            ? (int) str_replace(',', '', $request->salary_min)
            : null;

        $data['salary_max'] = $request->salary_max
            ? (int) str_replace(',', '', $request->salary_max)
            : null;

        

        $job->update([

                'title'                 => $request->title,
                'category'              => $request->category,
                'age_criteria'               => $request->age_criteria,
                'qualification_eligibility'  => $request->qualification_eligibility,
                'location'              => $request->location,
                'salary_min'            => $data['salary_min'],
                'salary_max'            => $data['salary_max'],
                'who_can_apply'         => $request->who_can_apply,
                'no_of_openings'        => $request->no_of_openings,
                'required_document'     => $request->required_document,
                'job_type'              => $request->job_type,
                'experience'            => $request->experience,
                'description'           => $request->description,
                'approval_status'       => 'pending',
                'posted_by_type'       =>'company'
            ]);

            Mail::to( $email)
                ->send(new JobPostedMail($job));

            return back()->with('success', 'Job posted successfully');
    }

    
    public function show($id)
        {
            // 1. Database se job find karein
           $job = Job::with('categoryData')->find($id);
           $applicationCount = Application::where('job_id', $id)->count();

            // 2. Check karein agar job nahi mili toh 404 error dikhayein
            if (!$job) {
                  return redirect()->back()->with('success', 'Job Not exist...');            
            }

            // 3. 'job' variable ko view mein bhejien (Ye sabse zaroori step hai)
            return view('jobs.show', compact('job','applicationCount'));   
        }


        public function dashboard(){
                $totalJobs = Job::count();

                $totalCompanies = Job::where('posted_by_type', 'company')->count();
                $candidateCount = User::where('role', 'candidate')->count();

                $totalApplications = Application::count();
                $totalCategories = Category::count();

                return view('admin.dashboard', compact(
                    'totalJobs',
                    'totalCompanies',
                    'totalApplications',
                    'totalCategories',
                    'candidateCount'
                ));
        }

         public function destroyApplication($id)
        {

             $Application = Application::find($id);

                if (!$Application) {
                    abort(404);
                }

                // 🔐 Only admin can delete
                if (auth()->user()->role !== 'admin') {
                    abort(403);
                }

                $Application->delete();

                return redirect()->back()->with('success', 'Application deleted successfully!');
        }
        
        public function find_job(Request $request)
            {
                // Categories with jobs
                $categories = Category::with(['jobs' => function ($query) {
                    $query->where(function ($q) {
                        $q->where('posted_by_type', 'admin')
                        ->orWhere(function ($q2) {
                            $q2->where('posted_by_type', 'company')
                                ->where('approval_status', 'approved');
                        });
                    })->latest();
                }])
                ->withCount(['jobs' => function ($query) {
                    $query->where(function ($q) {
                        $q->where('posted_by_type', 'admin')
                        ->orWhere(function ($q2) {
                            $q2->where('posted_by_type', 'company')
                                ->where('approval_status', 'approved');
                        });
                    });
                }])
                ->get();

                // Base job query
                $query = Job::with('categoryData');

                // Admin + Approved Company Logic
                $query->where(function ($q) {
                    $q->where('posted_by_type', 'admin')
                    ->orWhere(function ($q2) {
                        $q2->where('posted_by_type', 'company')
                            ->where('approval_status', 'approved');
                    });
                });

                // Filters
                $query->where(function ($q) use ($request) {

                    // TITLE
                    if ($request->filled('title')) {
                        $q->where('title', 'like', "%{$request->title}%");
                    }

                    // LOCATION (array support bhi safe)

                    if ($request->filled('locations')) {
                        $q->where(function ($loc) use ($request) {
                            foreach ($request->locations as $district) {
                                $loc->orWhere('district', 'like', "%{$district}%");
                            }
                        });
                    } elseif ($request->filled('location')) {
                        $q->where('district', 'like', "%{$request->location}%");
                    }

                    // CATEGORY
                    if ($request->filled('category')) {
                        $q->whereHas('categoryData', function ($cat) use ($request) {
                            $cat->where('name', 'like', "%{$request->category}%");
                        });
                    }

                    // EXPERIENCE ✅ ADDED
                    if ($request->filled('experience')) {
                        $q->whereIn('experience', $request->experience);
                    }

                    // JOB TYPE
                    if ($request->filled('job_type')) {
                        $q->whereIn('job_type', $request->job_type);
                    }

                    // SALARY
                    if ($request->filled('salary')) {

                        $ranges = [
                            '0-3' => [0, 300000],
                            '3-6' => [300000, 600000],
                            '6-10'=>[600000,1000000],
                            '10-15'=>[1000000,1500000]
                        ];

                        if (isset($ranges[$request->salary])) {
                            [$min, $max] = $ranges[$request->salary];

                            $q->where('salary_min', '>=', $min)
                            ->where('salary_max', '<=', $max);
                        }
                    }
                });

                $jobs = $query->latest()->get();
                $districts = Job::select('district')
                                   ->whereNotNull('district')
                                   ->distinct()
                                   ->pluck('district');
                return view('jobs.find-job', compact('jobs', 'categories','districts'));
            }

    public function updateStatus($id, $status)
        {
            // Valid status check (security + bug avoid)
            if (!in_array($status, ['approved', 'rejected'])) {
                return redirect()->back()->with('error', 'Invalid status');
            }

            $job = Job::find($id);

            if (!$job) {
                return redirect()->back()->with('error', 'Job not found');
            }

            // Update status
            $job->approval_status = $status;
            $job->save();

            return redirect()->back()->with('success', 'Job status updated successfully');
        }
                
    public function companiesJob()
        {
            $jobs = Job::where('posted_by_type', 'company')->get();
            return view('admin.company_job.index', compact('jobs'));
        }
         
}