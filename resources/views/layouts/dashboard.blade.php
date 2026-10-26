@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Dashboard Sidebar -->
        <div class="col-lg-3">
            <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
                <div class="p-4 text-center bg-white border-bottom">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle mb-3 border shadow-sm" style="width: 84px; height: 84px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold mx-auto mb-3 shadow-sm" style="width: 84px; height: 84px; font-size: 32px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <h6 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-2">{{ Auth::user()->email }}</p>
                    <span class="badge 
                        @if(Auth::user()->isAdmin()) bg-danger-subtle text-danger border border-danger-subtle
                        @elseif(Auth::user()->isEmployer()) bg-success-subtle text-success border border-success-subtle
                        @else bg-primary-subtle text-primary border border-primary-subtle @endif rounded-pill px-3 py-1">
                        @if(Auth::user()->isAdmin()) Quản trị viên
                        @elseif(Auth::user()->isEmployer()) Nhà tuyển dụng
                        @else Ứng viên tìm việc @endif
                    </span>
                </div>

                <div class="list-group list-group-flush p-2">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Tổng quan hệ thống
                        </a>
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.users') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-people me-2"></i> Quản lý người dùng
                        </a>
                        <a href="{{ route('admin.companies') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.companies') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-buildings me-2"></i> Quản lý doanh nghiệp
                        </a>
                        <a href="{{ route('admin.jobs') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.jobs') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-file-earmark-text me-2"></i> Quản lý tin tuyển dụng
                        </a>
                        <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('admin.categories') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-tags me-2"></i> Danh mục ngành nghề
                        </a>
                    @elseif(Auth::user()->isEmployer())
                        <a href="{{ route('employer.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('employer.dashboard') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Bảng điều khiển NTD
                        </a>
                        <a href="{{ route('employer.jobs.create') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('employer.jobs.create') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-plus-circle me-2 text-success"></i> Đăng tin tuyển dụng mới
                        </a>
                        <a href="{{ route('employer.jobs.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('employer.jobs.*') && !request()->routeIs('employer.jobs.create') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-list-check me-2"></i> Quản lý tin tuyển dụng
                        </a>
                        <a href="{{ route('employer.applications.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('employer.applications.*') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-inbox me-2"></i> Danh sách hồ sơ ứng tuyển
                        </a>
                        <a href="{{ route('employer.company_profile') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('employer.company_profile') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-building me-2"></i> Thông tin thương hiệu
                        </a>
                        <a href="{{ route('candidates.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1">
                            <i class="bi bi-search me-2"></i> Tìm kiếm ứng viên (Talent)
                        </a>
                    @else
                        <a href="{{ route('candidate.dashboard') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('candidate.dashboard') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Bảng điều khiển cá nhân
                        </a>
                        <a href="{{ route('candidate.profile') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('candidate.profile') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-person-lines-fill me-2"></i> Quản lý CV & Hồ sơ
                        </a>
                        <a href="{{ route('candidate.applications') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('candidate.applications') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-send-check me-2"></i> Việc làm đã ứng tuyển
                        </a>
                        <a href="{{ route('candidate.saved_jobs') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 {{ request()->routeIs('candidate.saved_jobs') ? 'active bg-primary text-white fw-bold' : '' }}">
                            <i class="bi bi-heart me-2 text-danger"></i> Việc làm đã lưu
                        </a>
                        <a href="{{ route('jobs.index') }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1">
                            <i class="bi bi-search me-2"></i> Khám phá việc làm mới
                        </a>
                    @endif
                    <hr class="my-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action border-0 rounded-3 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Dashboard Main Content -->
        <div class="col-lg-9">
            @yield('dashboard_content')
        </div>
    </div>
</div>
@endsection
