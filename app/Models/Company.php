<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'cover_image',
        'website',
        'email',
        'phone',
        'company_size',
        'city',
        'address',
        'industry',
        'description',
        'is_verified',
        'is_featured',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobPosting::class);
    }

    public function activeJobs()
    {
        return $this->hasMany(JobPosting::class)->where('status', 'published');
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            if (str_starts_with($this->logo, 'http')) {
                return $this->logo;
            }
            return asset('storage/' . $this->logo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0284c7&color=fff&size=128';
    }
}
