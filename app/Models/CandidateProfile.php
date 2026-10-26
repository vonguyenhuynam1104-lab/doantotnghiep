<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'experience_years',
        'expected_salary',
        'skills',
        'education',
        'resume_path',
        'city',
        'address',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'experience_years' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSkillsListAttribute()
    {
        if (empty($this->skills)) {
            return [];
        }
        return array_map('trim', explode(',', $this->skills));
    }
}
