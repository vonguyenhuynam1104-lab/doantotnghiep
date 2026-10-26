<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = CandidateProfile::with('user')
            ->where('is_public', true)
            ->whereHas('user', function ($q) {
                $q->where('is_active', true);
            });

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('skills', 'like', "%{$keyword}%")
                  ->orWhere('bio', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($uq) use ($keyword) {
                      $uq->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        if ($request->filled('city') && $request->city !== 'Tất cả') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        if ($request->filled('exp')) {
            $exp = (int) $request->exp;
            $query->where('experience_years', '>=', $exp);
        }

        $candidates = $query->latest()->paginate(12)->withQueryString();
        $cities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ'];

        return view('candidates.index', compact('candidates', 'cities'));
    }

    public function show($id)
    {
        $candidate = CandidateProfile::with('user')->findOrFail($id);
        return view('candidates.show', compact('candidate'));
    }
}
