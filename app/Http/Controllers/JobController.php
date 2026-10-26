<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\JobPosting;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::with('company', 'category')
            ->where('status', 'published');

        // Tìm kiếm theo từ khóa
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('skills_required', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhereHas('company', function ($cq) use ($keyword) {
                      $cq->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        // Lọc theo ngành nghề
        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->orWhere('id', $request->category)->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        // Lọc theo địa điểm
        if ($request->filled('city') && $request->city !== 'Tất cả địa điểm') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Lọc theo hình thức làm việc
        if ($request->filled('job_type') && $request->job_type !== 'all') {
            $query->where('job_type', $request->job_type);
        }

        // Lọc theo cấp bậc
        if ($request->filled('experience_level') && $request->experience_level !== 'all') {
            $query->where('experience_level', $request->experience_level);
        }

        // Lọc theo mức lương
        if ($request->filled('salary_range')) {
            switch ($request->salary_range) {
                case 'under_10m':
                    $query->where(function ($q) {
                        $q->where('salary_max', '<=', 10000000)
                          ->orWhere('salary_min', '<=', 10000000);
                    });
                    break;
                case '10m_20m':
                    $query->where('salary_min', '>=', 10000000)
                          ->where('salary_max', '<=', 25000000);
                    break;
                case '20m_35m':
                    $query->where('salary_min', '>=', 20000000)
                          ->where('salary_max', '<=', 40000000);
                    break;
                case 'above_35m':
                    $query->where('salary_max', '>=', 35000000);
                    break;
                case 'negotiable':
                    $query->where('is_negotiable', true);
                    break;
            }
        }

        // Sắp xếp
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'salary_desc' => $query->orderBy('salary_max', 'desc'),
            'views_desc' => $query->orderBy('views_count', 'desc'),
            'deadline_asc' => $query->orderBy('deadline', 'asc'),
            default => $query->latest(),
        };

        $jobs = $query->paginate(10)->withQueryString();

        $categories = Category::withCount(['jobs' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Toàn quốc'];

        return view('jobs.index', compact('jobs', 'categories', 'cities'));
    }

    public function show($slug)
    {
        $job = JobPosting::with(['company', 'category', 'applications'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tăng lượt xem
        $job->increment('views_count');

        $user = Auth::user();
        $hasApplied = false;
        $isSaved = false;
        $myApplication = null;

        if ($user) {
            $myApplication = Application::where('job_posting_id', $job->id)
                ->where('user_id', $user->id)
                ->first();
            $hasApplied = !is_null($myApplication);
            $isSaved = SavedJob::where('job_posting_id', $job->id)
                ->where('user_id', $user->id)
                ->exists();
        }

        // Việc làm liên quan
        $relatedJobs = JobPosting::with('company')
            ->where('status', 'published')
            ->where('id', '!=', $job->id)
            ->where(function ($q) use ($job) {
                $q->where('category_id', $job->category_id)
                  ->orWhere('city', $job->city);
            })
            ->latest()
            ->take(4)
            ->get();

        // Việc làm khác của công ty này
        $companyOtherJobs = JobPosting::where('company_id', $job->company_id)
            ->where('status', 'published')
            ->where('id', '!=', $job->id)
            ->take(3)
            ->get();

        return view('jobs.show', compact('job', 'hasApplied', 'isSaved', 'myApplication', 'relatedJobs', 'companyOtherJobs'));
    }

    public function apply(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập với tài khoản Ứng viên để nộp hồ sơ ứng tuyển.');
        }

        $user = Auth::user();
        if ($user->role !== 'candidate') {
            return back()->with('error', 'Chỉ tài khoản Ứng viên mới có thể nộp đơn ứng tuyển.');
        }

        $job = JobPosting::findOrFail($id);

        if ($job->status !== 'published') {
            return back()->with('error', 'Tin tuyển dụng này hiện đã đóng hoặc tạm dừng nhận hồ sơ.');
        }

        // Kiểm tra xem đã ứng tuyển chưa
        $existing = Application::where('job_posting_id', $job->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Bạn đã nộp hồ sơ cho vị trí này trước đó rồi.');
        }

        $request->validate([
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|email|max:255',
            'candidate_phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:2000',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // max 5MB
        ], [
            'candidate_name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'candidate_email.required' => 'Vui lòng nhập email liên hệ.',
            'candidate_phone.required' => 'Vui lòng nhập số điện thoại.',
            'resume_file.mimes' => 'Hồ sơ CV phải là file PDF, DOC hoặc DOCX.',
            'resume_file.max' => 'Dung lượng file CV không được vượt quá 5MB.',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume_file')) {
            $resumePath = $request->file('resume_file')->store('resumes', 'public');
        } elseif ($user->candidateProfile && $user->candidateProfile->resume_path) {
            $resumePath = $user->candidateProfile->resume_path;
        }

        Application::create([
            'job_posting_id' => $job->id,
            'user_id' => $user->id,
            'candidate_name' => $request->candidate_name,
            'candidate_email' => $request->candidate_email,
            'candidate_phone' => $request->candidate_phone,
            'resume_path' => $resumePath,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Nộp hồ sơ ứng tuyển thành công! Nhà tuyển dụng sẽ xem xét và phản hồi cho bạn sớm nhất.');
    }

    public function toggleSave($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để lưu việc làm.'], 401);
        }

        $user = Auth::user();
        $job = JobPosting::findOrFail($id);

        $saved = SavedJob::where('user_id', $user->id)
            ->where('job_posting_id', $job->id)
            ->first();

        if ($saved) {
            $saved->delete();
            $isSaved = false;
            $msg = 'Đã hủy lưu việc làm.';
        } else {
            SavedJob::create([
                'user_id' => $user->id,
                'job_posting_id' => $job->id,
            ]);
            $isSaved = true;
            $msg = 'Đã lưu việc làm vào danh sách yêu thích!';
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_saved' => $isSaved,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }
}
