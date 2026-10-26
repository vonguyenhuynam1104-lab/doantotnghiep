<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobPosting;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile ?? CandidateProfile::create([
            'user_id' => $user->id,
            'title' => 'Ứng viên',
            'is_public' => true,
        ]);

        $stats = [
            'total_applied' => Application::where('user_id', $user->id)->count(),
            'pending' => Application::where('user_id', $user->id)->where('status', 'pending')->count(),
            'interviewing' => Application::where('user_id', $user->id)->where('status', 'interviewing')->count(),
            'accepted' => Application::where('user_id', $user->id)->where('status', 'accepted')->count(),
            'saved' => SavedJob::where('user_id', $user->id)->count(),
        ];

        $recentApplications = Application::with(['job.company'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recommendedJobs = JobPosting::with('company')
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        return view('candidate.dashboard', compact('user', 'profile', 'stats', 'recentApplications', 'recommendedJobs'));
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->candidateProfile ?? CandidateProfile::firstOrCreate(['user_id' => $user->id]);

        return view('candidate.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->candidateProfile ?? CandidateProfile::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'expected_salary' => 'nullable|string|max:100',
            'skills' => 'nullable|string|max:500',
            'education' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'is_public' => 'nullable|boolean',
            'avatar_file' => 'nullable|image|max:2048',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'title.required' => 'Chức danh nghề nghiệp không được để trống.',
            'avatar_file.image' => 'Ảnh đại diện phải là định dạng hình ảnh.',
            'resume_file.mimes' => 'File CV phải có định dạng PDF, DOC hoặc DOCX.',
        ]);

        // Cập nhật User
        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $user->avatar = asset('storage/' . $path);
        }
        $user->save();

        // Cập nhật Profile
        $profile->title = $validated['title'];
        $profile->bio = $validated['bio'] ?? null;
        $profile->experience_years = $validated['experience_years'] ?? 0;
        $profile->expected_salary = $validated['expected_salary'] ?? null;
        $profile->skills = $validated['skills'] ?? null;
        $profile->education = $validated['education'] ?? null;
        $profile->city = $validated['city'] ?? null;
        $profile->address = $validated['address'] ?? null;
        $profile->linkedin_url = $validated['linkedin_url'] ?? null;
        $profile->github_url = $validated['github_url'] ?? null;
        $profile->portfolio_url = $validated['portfolio_url'] ?? null;
        $profile->is_public = $request->has('is_public');

        if ($request->hasFile('resume_file')) {
            $resumePath = $request->file('resume_file')->store('resumes', 'public');
            $profile->resume_path = $resumePath;
        }

        $profile->save();

        return back()->with('success', 'Hồ sơ cá nhân và CV đã được cập nhật thành công!');
    }

    public function applications(Request $request)
    {
        $user = Auth::user();
        $query = Application::with(['job.company', 'job.category'])
            ->where('user_id', $user->id);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10)->withQueryString();

        return view('candidate.applications', compact('applications'));
    }

    public function savedJobs()
    {
        $user = Auth::user();
        $savedJobs = SavedJob::with(['job.company', 'job.category'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('candidate.saved-jobs', compact('savedJobs'));
    }
}
