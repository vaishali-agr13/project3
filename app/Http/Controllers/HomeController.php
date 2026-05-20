<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Job; // Job model ko import karein
use App\Models\Category; // Job model ko import karein

class HomeController extends Controller
{
    public function index()
    {
        // Database se sirf wahi jobs lein jo active hain (status = 1) 
        // aur latest jobs ko upar dikhayein. Limit humne 6 rakhi hai.

        $categories = Category::with(['jobs' => function ($query) {
                $query->where(function ($q) {
                    $q->where('posted_by_type', 'admin')
                    ->orWhere(function ($q2) {
                        $q2->where('posted_by_type', 'company')
                            ->where('approval_status', 'approved');
                    });
                });
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
            
        $featuredJobs = Job::where(function($query) {
                $query->where('posted_by_type', 'admin')
                    ->orWhere(function($q) {
                        $q->where('posted_by_type', 'company')
                            ->where('approval_status', 'approved');
                    });
        })->get();
       
        // $featuredJobs = Job::where('status', 1)
        //                    ->orderBy('created_at', 'desc')
        //                    ->get();
    
        return view('home', compact('featuredJobs','categories'));
    }

    public function about()
    {
        return view('about');
    }
    
    public function services()
    {
         return view('services');
    }
    
    public function privacy_policy()
    {
         return view('privacy_policy');
    }

    public function companies()
    { 
         $categories = Category::all();

         return view('company', compact('categories'));
    }

    

}
