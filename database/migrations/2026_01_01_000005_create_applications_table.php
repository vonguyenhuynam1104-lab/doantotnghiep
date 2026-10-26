<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('candidate_name');
            $table->string('candidate_email');
            $table->string('candidate_phone');
            $table->string('resume_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'viewed', 'interviewing', 'accepted', 'rejected'])->default('pending');
            $table->text('employer_note')->nullable();
            $table->dateTime('interview_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
