<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['jobs' => function ($q) {
            $q->where('status', 'published');
        }])->orderBy('jobs_count', 'desc')->take(8)->get();

        $featuredJobs = JobPosting::with('company', 'category')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $latestJobs = JobPosting::with('company', 'category')
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        $topCompanies = Company::withCount(['jobs' => function ($q) {
            $q->where('status', 'published');
        }])->where('is_featured', true)
          ->take(6)
          ->get();

        $stats = [
            'jobs' => JobPosting::where('status', 'published')->count(),
            'companies' => Company::count(),
            'candidates' => User::where('role', 'candidate')->count(),
            'applications' => \App\Models\Application::count(),
        ];

        return view('home', compact('categories', 'featuredJobs', 'latestJobs', 'topCompanies', 'stats'));
    }
}
