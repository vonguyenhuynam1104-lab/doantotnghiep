<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(); // Chức danh nghề nghiệp, vd: Senior Laravel Developer
            $table->text('bio')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('expected_salary')->nullable();
            $table->text('skills')->nullable(); // Kỹ năng chính, cách nhau dấu phẩy hoặc JSON
            $table->string('education')->nullable();
            $table->string('resume_path')->nullable(); // Đường dẫn file CV đính kèm
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->boolean('is_public')->default(true); // Cho phép nhà tuyển dụng tìm thấy
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
