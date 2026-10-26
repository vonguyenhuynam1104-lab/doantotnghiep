<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::withCount(['jobs' => function ($q) {
            $q->where('status', 'published');
        }]);

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('industry', 'like', "%{$keyword}%")
                  ->orWhere('city', 'like', "%{$keyword}%");
        }

        if ($request->filled('city') && $request->city !== 'Tất cả') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        $companies = $query->orderBy('is_featured', 'desc')
                           ->orderBy('jobs_count', 'desc')
                           ->paginate(12)
                           ->withQueryString();

        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ'];

        return view('companies.index', compact('companies', 'cities'));
    }

    public function show($slug)
    {
        $company = Company::withCount(['jobs' => function ($q) {
            $q->where('status', 'published');
        }])->where('slug', $slug)->firstOrFail();

        $jobs = $company->jobs()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        return view('companies.show', compact('company', 'jobs'));
    }
}
