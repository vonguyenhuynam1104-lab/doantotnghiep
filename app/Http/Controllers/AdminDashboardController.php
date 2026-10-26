<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'candidates_count' => User::where('role', 'candidate')->count(),
            'employers_count' => User::where('role', 'employer')->count(),
            'companies_count' => Company::count(),
            'jobs_count' => JobPosting::count(),
            'active_jobs_count' => JobPosting::where('status', 'published')->count(),
            'applications_count' => Application::count(),
        ];

        $recentUsers = User::latest()->take(6)->get();
        $recentJobs = JobPosting::with('company')->latest()->take(6)->get();
        $recentApplications = Application::with(['job.company'])->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs', 'recentApplications'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('email', 'like', "%{$request->q}%")
                  ->orWhere('phone', 'like', "%{$request->q}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản quản trị của chính mình!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'mở khóa' : 'khóa';
        return back()->with('success', "Đã {$statusStr} tài khoản người dùng thành công!");
    }

    public function companies(Request $request)
    {
        $query = Company::with('user')->withCount('jobs');

        if ($request->filled('q')) {
            $query->where('name', 'like', "%{$request->q}%")
                  ->orWhere('city', 'like', "%{$request->q}%");
        }

        $companies = $query->latest()->paginate(15)->withQueryString();

        return view('admin.companies', compact('companies'));
    }

    public function toggleCompanyVerified($id)
    {
        $company = Company::findOrFail($id);
        $company->is_verified = !$company->is_verified;
        $company->save();

        $statusStr = $company->is_verified ? 'Xác thực thành công' : 'Hủy xác thực';
        return back()->with('success', "{$statusStr} cho công ty {$company->name}!");
    }

    public function jobs(Request $request)
    {
        $query = JobPosting::with(['company', 'category'])->withCount('applications');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        $jobs = $query->latest()->paginate(15)->withQueryString();

        return view('admin.jobs', compact('jobs'));
    }

    public function deleteJob($id)
    {
        $job = JobPosting::findOrFail($id);
        $job->delete();

        return back()->with('success', 'Đã gỡ bỏ tin tuyển dụng khỏi hệ thống!');
    }

    public function categories()
    {
        $categories = Category::withCount('jobs')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?: 'bi-briefcase',
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
        ]);

        return back()->with('success', 'Đã thêm danh mục ngành nghề mới thành công!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->jobs()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục đang có tin tuyển dụng!');
        }

        $category->delete();
        return back()->with('success', 'Đã xóa danh mục thành công!');
    }
}
