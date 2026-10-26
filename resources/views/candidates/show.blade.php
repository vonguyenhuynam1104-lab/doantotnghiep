@extends('layouts.app')

@section('title', 'Hồ Sơ Ứng Viên: ' . $candidate->user->name . ' | JobConnect')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}" class="text-decoration-none">Ứng viên</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $candidate->user->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="card card-custom p-4 border shadow-sm mb-4">
        <div class="d-flex flex-column flex-md-row gap-4 align-items-center align-items-md-start justify-content-between text-center text-md-start">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-center align-items-md-start">
                @if($candidate->user->avatar)
                    <img src="{{ $candidate->user->avatar }}" alt="{{ $candidate->user->name }}" class="rounded-circle shadow-sm border" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 100px; height: 100px; font-size: 40px;">
                        {{ strtoupper(substr($candidate->user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h3 class="fw-bold text-dark mb-1">{{ $candidate->user->name }}</h3>
                    <p class="text-primary fw-semibold fs-5 mb-2">{{ $candidate->title }}</p>
                    <div class="d-flex flex-wrap gap-3 text-muted small justify-content-center justify-content-md-start">
                        <span><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $candidate->city ?: 'Hà Nội' }}</span>
                        <span><i class="bi bi-briefcase me-1 text-primary"></i> {{ $candidate->experience_years }} năm kinh nghiệm</span>
                        @if($candidate->expected_salary)
                            <span><i class="bi bi-cash-stack me-1 text-success"></i> Mức lương mong muốn: {{ $candidate->expected_salary }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                @if($candidate->resume_path)
                    <a href="{{ asset('storage/' . $candidate->resume_path) }}" target="_blank" class="btn btn-primary-gradient rounded-pill px-4 py-2 fw-semibold">
                        <i class="bi bi-download me-1"></i> Tải CV bản gốc
                    </a>
                @endif
                @if($candidate->user->email)
                    <a href="mailto:{{ $candidate->user->email }}" class="btn btn-outline-custom rounded-pill px-4 py-2 fw-semibold">
                        <i class="bi bi-envelope me-1"></i> Liên hệ tuyển dụng
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Bio / Giới thiệu bản thân -->
            <div class="card card-custom p-4 border shadow-sm mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-fill text-primary me-2"></i>Giới Thiệu Bản Thân</h5>
                <p class="text-secondary lh-lg mb-0" style="white-space: pre-line;">
                    {{ $candidate->bio ?: 'Ứng viên chưa cập nhật phần giới thiệu cá nhân.' }}
                </p>
            </div>

            <!-- Skills -->
            @if(!empty($candidate->skills_list))
                <div class="card card-custom p-4 border shadow-sm mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-tools text-warning me-2"></i>Kỹ Năng Chuyên Môn</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($candidate->skills_list as $skill)
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fs-6 fw-normal">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Education -->
            @if($candidate->education)
                <div class="card card-custom p-4 border shadow-sm mb-4">
                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-mortarboard-fill text-success me-2"></i>Trình Độ Học Vấn</h5>
                    <p class="text-secondary mb-0">{{ $candidate->education }}</p>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card card-custom p-4 border shadow-sm mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Thông Tin Liên Hệ</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted mb-0">
                    <li><i class="bi bi-envelope me-2 text-primary"></i> Email: <strong class="text-dark">{{ $candidate->user->email }}</strong></li>
                    @if($candidate->user->phone)
                        <li><i class="bi bi-telephone me-2 text-primary"></i> SĐT: <strong class="text-dark">{{ $candidate->user->phone }}</strong></li>
                    @endif
                    @if($candidate->address)
                        <li><i class="bi bi-geo-alt me-2 text-primary"></i> Địa chỉ: <strong class="text-dark">{{ $candidate->address }}</strong></li>
                    @endif
                    @if($candidate->linkedin_url)
                        <li><i class="bi bi-linkedin me-2 text-primary"></i> LinkedIn: <a href="{{ $candidate->linkedin_url }}" target="_blank" class="text-decoration-none">Xem hồ sơ</a></li>
                    @endif
                    @if($candidate->github_url)
                        <li><i class="bi bi-github me-2 text-dark"></i> GitHub: <a href="{{ $candidate->github_url }}" target="_blank" class="text-decoration-none">Xem Portfolio Code</a></li>
                    @endif
                    @if($candidate->portfolio_url)
                        <li><i class="bi bi-globe me-2 text-primary"></i> Website cá nhân: <a href="{{ $candidate->portfolio_url }}" target="_blank" class="text-decoration-none">{{ $candidate->portfolio_url }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
