<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'slug',
        'job_type',
        'experience_level',
        'salary_min',
        'salary_max',
        'is_negotiable',
        'city',
        'address',
        'deadline',
        'quantity',
        'description',
        'requirements',
        'benefits',
        'skills_required',
        'views_count',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'is_negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'deadline' => 'date',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
        'quantity' => 'integer',
        'views_count' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function getSalaryFormattedAttribute()
    {
        if ($this->is_negotiable) {
            return 'Thoả thuận';
        }

        if ($this->salary_min && $this->salary_max) {
            return number_format($this->salary_min / 1000000, 0) . ' - ' . number_format($this->salary_max / 1000000, 0) . ' Triệu';
        } elseif ($this->salary_min) {
            return 'Từ ' . number_format($this->salary_min / 1000000, 0) . ' Triệu';
        } elseif ($this->salary_max) {
            return 'Tới ' . number_format($this->salary_max / 1000000, 0) . ' Triệu';
        }

        return 'Thoả thuận';
    }

    public function getSkillsListAttribute()
    {
        if (empty($this->skills_required)) {
            return [];
        }
        return array_map('trim', explode(',', $this->skills_required));
    }

    public function isSavedBy($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }
        if (!$user) {
            return false;
        }
        return $this->savedJobs()->where('user_id', $user->id)->exists();
    }

    public function hasAppliedBy($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }
        if (!$user) {
            return false;
        }
        return $this->applications()->where('user_id', $user->id)->exists();
    }
}
