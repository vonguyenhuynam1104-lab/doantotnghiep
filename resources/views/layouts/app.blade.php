<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobConnect - Cổng Thông Tin Việc Làm & Kết Nối Tuyển Dụng Hàng Đầu')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #eff6ff;
            --secondary: #0f172a;
            --accent: #10b981;
            --accent-purple: #8b5cf6;
            --bg-light: #f8fafc;
            --card-border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand .brand-badge {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .nav-link {
            font-weight: 500;
            color: #334155 !important;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }

        /* Buttons */
        .btn-primary-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
            transition: all 0.25s ease;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        .btn-accent-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 10px 22px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
            transition: all 0.25s ease;
        }

        .btn-accent-gradient:hover {
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
        }

        .btn-outline-custom {
            border: 1.5px solid #cbd5e1;
            font-weight: 600;
            color: #334155;
            border-radius: 10px;
            padding: 9px 20px;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Cards & Lift effect */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px -10px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        /* Soft Badges */
        .badge-soft-primary {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            padding: 5px 10px;
        }

        .badge-soft-success {
            background-color: #ecfdf5;
            color: #065f46;
            font-weight: 600;
            border: 1px solid #a7f3d0;
            border-radius: 6px;
            padding: 5px 10px;
        }

        .badge-soft-warning {
            background-color: #fffbeb;
            color: #92400e;
            font-weight: 600;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 5px 10px;
        }

        .badge-soft-danger {
            background-color: #fef2f2;
            color: #991b1b;
            font-weight: 600;
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 5px 10px;
        }

        .badge-soft-purple {
            background-color: #faf5ff;
            color: #6b21a8;
            font-weight: 600;
            border: 1px solid #e9d5ff;
            border-radius: 6px;
            padding: 5px 10px;
        }

        /* Footer */
        .footer {
            background-color: #0f172a;
            color: #94a3b8;
            margin-top: auto;
            border-top: 1px solid #1e293b;
        }

        .footer h6 {
            color: #ffffff;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: #60a5fa;
        }

        .company-logo-img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        /* Avatar */
        .user-avatar-sm {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-badge"><i class="bi bi-briefcase-fill"></i></span>
                <span>Job<span class="text-primary">Connect</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}" href="{{ route('jobs.index') }}">
                            <i class="bi bi-search me-1"></i> Việc làm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}" href="{{ route('companies.index') }}">
                            <i class="bi bi-buildings me-1"></i> Công ty
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}" href="{{ route('candidates.index') }}">
                            <i class="bi bi-people me-1"></i> Ứng viên tài năng
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-custom">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary-gradient">
                            <i class="bi bi-person-plus me-1"></i> Đăng ký
                        </a>
                        <a href="{{ route('register') }}?role=employer" class="btn btn-outline-primary d-none d-xl-inline-block rounded-pill fw-semibold px-3 py-2 ms-2">
                            <i class="bi bi-megaphone me-1"></i> Đăng tin tuyển dụng
                        </a>
                    @else
                        <!-- Logged In User Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill border dropdown-toggle d-flex align-items-center gap-2 px-3 py-2" type="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="user-avatar-sm">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 13px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="text-start d-none d-md-block">
                                    <div class="fw-bold text-dark lh-sm" style="font-size: 14px;">{{ Str::limit(Auth::user()->name, 16) }}</div>
                                    <small class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 10px;">
                                        @if(Auth::user()->isAdmin())
                                            Quản trị viên
                                        @elseif(Auth::user()->isEmployer())
                                            Nhà tuyển dụng
                                        @else
                                            Ứng viên
                                        @endif
                                    </small>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2 p-2" style="min-width: 230px;">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Quản trị hệ thống</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.users') }}"><i class="bi bi-people me-2 text-info"></i> Quản lý người dùng</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('admin.jobs') }}"><i class="bi bi-file-earmark-text me-2 text-success"></i> Quản lý việc làm</a></li>
                                @elseif(Auth::user()->isEmployer())
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employer.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Bảng điều khiển NTD</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employer.jobs.create') }}"><i class="bi bi-plus-circle me-2 text-success"></i> Đăng việc làm mới</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employer.jobs.index') }}"><i class="bi bi-list-check me-2 text-primary"></i> Danh sách tin đăng</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employer.applications.index') }}"><i class="bi bi-inbox me-2 text-warning"></i> Hồ sơ ứng tuyển</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employer.company_profile') }}"><i class="bi bi-building me-2 text-secondary"></i> Thông tin công ty</a></li>
                                @else
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('candidate.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Bảng điều khiển cá nhân</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('candidate.profile') }}"><i class="bi bi-person-badge me-2 text-info"></i> Cập nhật CV & Hồ sơ</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('candidate.applications') }}"><i class="bi bi-send-check me-2 text-success"></i> Việc làm đã nộp</a></li>
                                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('candidate.saved_jobs') }}"><i class="bi bi-bookmark-heart me-2 text-danger"></i> Việc làm đã lưu</a></li>
                                @endif
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle me-1"></i> Có một số lỗi phát sinh, vui lòng kiểm tra:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Page Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a class="navbar-brand text-white mb-3" href="{{ route('home') }}">
                        <span class="brand-badge"><i class="bi bi-briefcase-fill"></i></span>
                        <span>Job<span class="text-primary">Connect</span></span>
                    </a>
                    <p class="text-muted pe-lg-4 mt-2">
                        Nền tảng công nghệ kết nối việc làm thông minh, giúp ứng viên tìm kiếm cơ hội nghề nghiệp lý tưởng và hỗ trợ doanh nghiệp chiêu mộ nhân tài nhanh chóng, hiệu quả.
                    </p>
                    <div class="d-flex gap-3 fs-5 mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-github"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Dành Cho Ứng Viên</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('jobs.index') }}">Tìm kiếm việc làm</a></li>
                        <li><a href="{{ route('companies.index') }}">Danh sách công ty</a></li>
                        <li><a href="{{ route('candidate.profile') }}">Tạo CV trực tuyến</a></li>
                        <li><a href="{{ route('candidate.saved_jobs') }}">Việc làm đã lưu</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6>Nhà Tuyển Dụng</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('employer.jobs.create') }}">Đăng tin tuyển dụng</a></li>
                        <li><a href="{{ route('candidates.index') }}">Tìm kiếm hồ sơ ứng viên</a></li>
                        <li><a href="{{ route('employer.dashboard') }}">Bảng điều khiển NTD</a></li>
                        <li><a href="{{ route('employer.applications.index') }}">Quản trị hồ sơ ứng viên</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6>Liên Hệ & Trụ Sở</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted">
                        <li><i class="bi bi-geo-alt me-2 text-primary"></i> Tầng 8, Tòa nhà Công nghệ cao, Cầu Giấy, Hà Nội</li>
                        <li><i class="bi bi-telephone me-2 text-primary"></i> Hotline: 1900 6868 - 024.7300.9999</li>
                        <li><i class="bi bi-envelope me-2 text-primary"></i> Email: contact@jobconnect.vn</li>
                        <li><i class="bi bi-shield-check me-2 text-success"></i> Đồ án tốt nghiệp Công nghệ Thông tin - Chuẩn MVC Laravel & MySQL</li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <small class="text-muted">© 2026 JobConnect Platform. Bảo lưu mọi quyền. Đồ án tốt nghiệp.</small>
                <div class="d-flex gap-3 text-muted" style="font-size: 13px;">
                    <a href="#">Điều khoản sử dụng</a>
                    <a href="#">Chính sách bảo mật</a>
                    <a href="#">Quy chế hoạt động</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // CSRF Token setup for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Quick toggle save job AJAX
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-save-job');
            if (btn) {
                e.preventDefault();
                const jobId = btn.dataset.jobId;
                fetch(`/viec-lam/${jobId}/luu-tin`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data && data.success) {
                        const icon = btn.querySelector('i');
                        if (data.is_saved) {
                            btn.classList.add('btn-danger', 'text-white');
                            btn.classList.remove('btn-outline-danger');
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                        } else {
                            btn.classList.remove('btn-danger', 'text-white');
                            btn.classList.add('btn-outline-danger');
                            icon.classList.remove('bi-heart-fill');
                            icon.classList.add('bi-heart');
                        }
                    }
                })
                .catch(err => console.error(err));
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
