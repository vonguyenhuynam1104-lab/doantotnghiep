<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('job_type', ['Full-time', 'Part-time', 'Remote', 'Internship', 'Freelance'])->default('Full-time');
            $table->enum('experience_level', [
                'Tất cả cấp bậc',
                'Thực tập sinh',
                'Mới tốt nghiệp / Fresher',
                'Nhân viên / Junior-Middle',
                'Trưởng nhóm / Senior',
                'Quản lý / Trưởng phòng'
            ])->default('Nhân viên / Junior-Middle');
            $table->unsignedBigInteger('salary_min')->nullable();
            $table->unsignedBigInteger('salary_max')->nullable();
            $table->boolean('is_negotiable')->default(false);
            $table->string('city')->default('Hà Nội');
            $table->string('address')->nullable();
            $table->date('deadline')->nullable();
            $table->integer('quantity')->default(1);
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->longText('benefits')->nullable();
            $table->text('skills_required')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->enum('status', ['published', 'draft', 'closed', 'pending_approval'])->default('published');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
