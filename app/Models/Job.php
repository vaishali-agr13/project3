<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Job extends Model
{
    use HasFactory;

    // Kaunse fields database mein direct save ho sakte hain
    protected $fillable = [
        'title',
        'category',
        'company_name',
        'company_email',
         'company_phone',
        'website',
        'pincode',
        'state',
        'district',
        'address',
        'location',
        'salary_min',
        'salary_max',
        'posted_by_type',
        'description',
        'job_type',
        'status',
        'experience',
        'roles_responsibility',
        'skills_required',
        'who_can_apply',
        'approval_status',
        'no_of_openings',
    ];
    protected $casts = [
        'skills_required' => 'array',
    ];

    public function categoryData()
    {
      return $this->belongsTo(Category::class, 'category', 'id');
    }
}