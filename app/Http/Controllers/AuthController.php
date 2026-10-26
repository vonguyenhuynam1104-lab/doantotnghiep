<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ ban quản trị.');
            }

            $request->session()->regenerate();
            return $this->redirectBasedOnRole($user)->with('success', 'Đăng nhập thành công! Chào mừng bạn trở lại.');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'candidate');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:candidate,employer',
        ];

        if ($role === 'employer') {
            $rules['company_name'] = 'required|string|max:255';
            $rules['city'] = 'required|string';
            $rules['company_size'] = 'nullable|string';
            $rules['industry'] = 'nullable|string';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Vui lòng nhập họ và tên hoặc người đại diện.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã được đăng ký trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'company_name.required' => 'Vui lòng nhập tên công ty/doanh nghiệp.',
            'city.required' => 'Vui lòng chọn tỉnh/thành phố.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        if ($role === 'candidate') {
            CandidateProfile::create([
                'user_id' => $user->id,
                'title' => 'Ứng viên tiềm năng',
                'is_public' => true,
            ]);
        } elseif ($role === 'employer') {
            $slug = Str::slug($validated['company_name']);
            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (Company::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            Company::create([
                'user_id' => $user->id,
                'name' => $validated['company_name'],
                'slug' => $slug,
                'city' => $validated['city'] ?? 'Hà Nội',
                'company_size' => $validated['company_size'] ?? '10-50 nhân viên',
                'industry' => $validated['industry'] ?? 'Công nghệ thông tin',
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user)->with('success', 'Đăng ký tài khoản thành công! Bắt đầu trải nghiệm JobConnect ngay.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Bạn đã đăng xuất an toàn.');
    }

    protected function redirectBasedOnRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'employer' => redirect()->route('employer.dashboard'),
            default => redirect()->route('candidate.dashboard'),
        };
    }
}
