<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_posting_id',
        'user_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'resume_path',
        'cover_letter',
        'status',
        'employer_note',
        'interview_at',
    ];

    protected $casts = [
        'interview_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => ['label' => 'Đã nộp hồ sơ', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'viewed' => ['label' => 'Đã xem hồ sơ', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'interviewing' => ['label' => 'Mời phỏng vấn', 'class' => 'bg-purple-100 text-purple-800 border-purple-300'],
            'accepted' => ['label' => 'Trúng tuyển', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'rejected' => ['label' => 'Từ chối', 'class' => 'bg-rose-100 text-rose-800 border-rose-300'],
            default => ['label' => 'Chưa xác định', 'class' => 'bg-slate-100 text-slate-800 border-slate-300'],
        };
    }
}
