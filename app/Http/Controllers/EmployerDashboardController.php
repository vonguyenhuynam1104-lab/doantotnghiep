<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployerDashboardController extends Controller
{
    protected function getEmployerCompany()
    {
        $user = Auth::user();
        if (!$user->company) {
            $slug = Str::slug($user->name ?: 'Doanh nghiep');
            $original = $slug;
            $c = 1;
            while (Company::where('slug', $slug)->exists()) {
                $slug = $original . '-' . $c++;
            }
            return Company::create([
                'user_id' => $user->id,
                'name' => $user->name ?: 'Công ty của bạn',
                'slug' => $slug,
                'email' => $user->email,
                'phone' => $user->phone,
                'city' => 'Hà Nội',
                'company_size' => '10-50 nhân viên',
                'industry' => 'Công nghệ thông tin',
            ]);
        }
        return $user->company;
    }

    public function index()
    {
        $company = $this->getEmployerCompany();

        $jobIds = $company->jobs()->pluck('id');

        $stats = [
            'total_jobs' => $company->jobs()->count(),
            'active_jobs' => $company->jobs()->where('status', 'published')->count(),
            'total_applications' => Application::whereIn('job_posting_id', $jobIds)->count(),
            'pending_applications' => Application::whereIn('job_posting_id', $jobIds)->where('status', 'pending')->count(),
            'interviewing' => Application::whereIn('job_posting_id', $jobIds)->where('status', 'interviewing')->count(),
        ];

        $recentApplications = Application::with('job')
            ->whereIn('job_posting_id', $jobIds)
            ->latest()
            ->take(6)
            ->get();

        $activeJobs = $company->jobs()
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        return view('employer.dashboard', compact('company', 'stats', 'recentApplications', 'activeJobs'));
    }

    public function companyProfile()
    {
        $company = $this->getEmployerCompany();
        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Toàn quốc'];

        return view('employer.company-profile', compact('company', 'cities'));
    }

    public function updateCompany(Request $request)
    {
        $company = $this->getEmployerCompany();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:100',
            'industry' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'logo_file' => 'nullable|image|max:2048',
            'cover_file' => 'nullable|image|max:4096',
        ], [
            'name.required' => 'Tên công ty không được để trống.',
            'city.required' => 'Vui lòng chọn Tỉnh/Thành phố trụ sở.',
            'logo_file.image' => 'Logo phải là định dạng hình ảnh.',
            'cover_file.image' => 'Ảnh bìa phải là định dạng hình ảnh.',
        ]);

        if ($request->hasFile('logo_file')) {
            $logoPath = $request->file('logo_file')->store('company_logos', 'public');
            $validated['logo'] = asset('storage/' . $logoPath);
        }

        if ($request->hasFile('cover_file')) {
            $coverPath = $request->file('cover_file')->store('company_covers', 'public');
            $validated['cover_image'] = asset('storage/' . $coverPath);
        }

        $company->update($validated);

        return back()->with('success', 'Thông tin hồ sơ công ty đã được cập nhật thành công!');
    }

    public function jobs(Request $request)
    {
        $company = $this->getEmployerCompany();

        $query = $company->jobs()->with('category')->withCount('applications');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        return view('employer.jobs.index', compact('company', 'jobs'));
    }

    public function createJob()
    {
        $company = $this->getEmployerCompany();
        $categories = Category::all();
        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Toàn quốc'];

        return view('employer.jobs.create', compact('company', 'categories', 'cities'));
    }

    public function storeJob(Request $request)
    {
        $company = $this->getEmployerCompany();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type' => 'required|in:Full-time,Part-time,Remote,Internship,Freelance',
            'experience_level' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'is_negotiable' => 'nullable|boolean',
            'city' => 'required|string',
            'address' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after_or_equal:today',
            'quantity' => 'nullable|integer|min:1',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'skills_required' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề vị trí tuyển dụng.',
            'category_id.required' => 'Vui lòng chọn ngành nghề.',
            'description.required' => 'Vui lòng nhập mô tả công việc chi tiết.',
            'deadline.after_or_equal' => 'Hạn nộp hồ sơ phải từ ngày hôm nay trở đi.',
        ]);

        $slug = Str::slug($validated['title']);
        $original = $slug;
        $c = 1;
        while (JobPosting::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $c++;
        }

        JobPosting::create([
            'company_id' => $company->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'job_type' => $validated['job_type'],
            'experience_level' => $validated['experience_level'],
            'salary_min' => $request->has('is_negotiable') ? null : ($validated['salary_min'] ? $validated['salary_min'] * 1000000 : null),
            'salary_max' => $request->has('is_negotiable') ? null : ($validated['salary_max'] ? $validated['salary_max'] * 1000000 : null),
            'is_negotiable' => $request->has('is_negotiable'),
            'city' => $validated['city'],
            'address' => $validated['address'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'quantity' => $validated['quantity'] ?? 1,
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'benefits' => $validated['benefits'] ?? null,
            'skills_required' => $validated['skills_required'] ?? null,
            'status' => 'published',
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Đăng tin tuyển dụng mới thành công! Tin tuyển dụng đã được xuất bản.');
    }

    public function editJob($id)
    {
        $company = $this->getEmployerCompany();
        $job = $company->jobs()->findOrFail($id);
        $categories = Category::all();
        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Toàn quốc'];

        return view('employer.jobs.edit', compact('company', 'job', 'categories', 'cities'));
    }

    public function updateJob(Request $request, $id)
    {
        $company = $this->getEmployerCompany();
        $job = $company->jobs()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type' => 'required|in:Full-time,Part-time,Remote,Internship,Freelance',
            'experience_level' => 'required|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'is_negotiable' => 'nullable|boolean',
            'city' => 'required|string',
            'address' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'quantity' => 'nullable|integer|min:1',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'skills_required' => 'nullable|string|max:500',
            'status' => 'required|in:published,closed,draft',
        ]);

        $job->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'job_type' => $validated['job_type'],
            'experience_level' => $validated['experience_level'],
            'salary_min' => $request->has('is_negotiable') ? null : ($validated['salary_min'] ? $validated['salary_min'] * 1000000 : null),
            'salary_max' => $request->has('is_negotiable') ? null : ($validated['salary_max'] ? $validated['salary_max'] * 1000000 : null),
            'is_negotiable' => $request->has('is_negotiable'),
            'city' => $validated['city'],
            'address' => $validated['address'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'quantity' => $validated['quantity'] ?? 1,
            'description' => $validated['description'],
            'requirements' => $validated['requirements'] ?? null,
            'benefits' => $validated['benefits'] ?? null,
            'skills_required' => $validated['skills_required'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('employer.jobs.index')->with('success', 'Cập nhật tin tuyển dụng thành công!');
    }

    public function toggleJobStatus($id)
    {
        $company = $this->getEmployerCompany();
        $job = $company->jobs()->findOrFail($id);

        $newStatus = $job->status === 'published' ? 'closed' : 'published';
        $job->update(['status' => $newStatus]);

        $msg = $newStatus === 'published' ? 'Đã kích hoạt hiển thị tin tuyển dụng!' : 'Đã đóng tin tuyển dụng.';
        return back()->with('success', $msg);
    }

    public function deleteJob($id)
    {
        $company = $this->getEmployerCompany();
        $job = $company->jobs()->findOrFail($id);
        $job->delete();

        return back()->with('success', 'Đã xóa tin tuyển dụng thành công.');
    }

    public function applications(Request $request)
    {
        $company = $this->getEmployerCompany();
        $jobIds = $company->jobs()->pluck('id');

        $query = Application::with(['job', 'candidate.candidateProfile'])
            ->whereIn('job_posting_id', $jobIds);

        if ($request->filled('job_id') && $request->job_id !== 'all') {
            $query->where('job_posting_id', $request->job_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10)->withQueryString();
        $companyJobs = $company->jobs()->get();

        return view('employer.applications.index', compact('company', 'applications', 'companyJobs'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $company = $this->getEmployerCompany();
        $jobIds = $company->jobs()->pluck('id');

        $application = Application::whereIn('job_posting_id', $jobIds)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,viewed,interviewing,accepted,rejected',
            'employer_note' => 'nullable|string|max:1000',
            'interview_at' => 'nullable|date',
        ]);

        $application->update([
            'status' => $request->status,
            'employer_note' => $request->employer_note,
            'interview_at' => $request->interview_at,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái hồ sơ ứng viên và gửi phản hồi thành công!');
    }
}
