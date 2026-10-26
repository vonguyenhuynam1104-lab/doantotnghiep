<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(JobPosting::class);
    }

    public function activeJobs()
    {
        return $this->hasMany(JobPosting::class)->where('status', 'published');
    }
}
