@extends('layouts.dashboard')

@section('title', 'Bảng Điều Khiển Ứng Viên - JobConnect')

@section('dashboard_content')
<!-- Welcome Banner -->
<div class="card card-custom p-4 border shadow-sm mb-4" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); color: white;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-white">Xin chào, {{ $user->name }}! 👋</h4>
            <p class="mb-0 text-white-50">Chào mừng bạn trở lại. Hãy cập nhật CV thường xuyên để gia tăng cơ hội việc làm.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('candidate.profile') }}" class="btn btn-light rounded-pill fw-semibold px-3 py-2 text-primary">
                <i class="bi bi-pencil-square me-1"></i> Cập nhật CV
            </a>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-light rounded-pill fw-semibold px-3 py-2">
                <i class="bi bi-search me-1"></i> Tìm việc mới
            </a>
        </div>
    </div>
</div>

<!-- Stats Counter Grid -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-primary-subtle text-primary p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-send-check fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['total_applied'] }}</h3>
            <small class="text-muted">Đã ứng tuyển</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-warning-subtle text-warning p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-hourglass-split fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['pending'] }}</h3>
            <small class="text-muted">Đang chờ duyệt</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-purple-subtle text-purple p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center; background-color: #f3e8ff; color: #7e22ce;">
                <i class="bi bi-calendar-event fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['interviewing'] }}</h3>
            <small class="text-muted">Mời phỏng vấn</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-danger-subtle text-danger p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-heart fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['saved'] }}</h3>
            <small class="text-muted">Việc làm đã lưu</small>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-primary me-2"></i>Đơn Ứng Tuyển Gần Đây</h5>
        <a href="{{ route('candidate.applications') }}" class="small text-primary text-decoration-none fw-semibold">Xem tất cả</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Công việc / Công ty</th>
                    <th>Ngày nộp</th>
                    <th>Trạng thái</th>
                    <th>Phản hồi của NTD</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentApplications as $app)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $app->job->title }}</div>
                            <small class="text-muted">{{ $app->job->company->name }}</small>
                        </td>
                        <td class="text-muted small">{{ $app->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $app->status_badge['class'] }} border">
                                {{ $app->status_badge['label'] }}
                            </span>
                        </td>
                        <td class="small">
                            @if($app->interview_at)
                                <div class="text-purple fw-bold" style="color: #6b21a8;"><i class="bi bi-calendar-check me-1"></i> Phỏng vấn: {{ $app->interview_at->format('H:i d/m') }}</div>
                            @elseif($app->employer_note)
                                <span class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $app->employer_note }}">{{ $app->employer_note }}</span>
                            @else
                                <span class="text-muted">Chờ phản hồi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('jobs.show', $app->job->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                Xem tin
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Bạn chưa nộp hồ sơ vào vị trí nào. <a href="{{ route('jobs.index') }}">Khám phá việc làm ngay</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recommended Jobs for Candidate -->
<div class="card card-custom p-4 border shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-stars text-warning me-2"></i>Việc Làm Gợi Ý Cho Bạn</h5>
        <a href="{{ route('jobs.index') }}" class="small text-primary text-decoration-none fw-semibold">Khám phá thêm</a>
    </div>

    <div class="row g-3">
        @foreach($recommendedJobs as $rJob)
            <div class="col-md-6">
                <div class="p-3 border rounded-3 hover-shadow transition h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex gap-2 align-items-start mb-2">
                            <img src="{{ $rJob->company->logo_url }}" alt="logo" class="company-logo-img" style="width: 44px; height: 44px;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><a href="{{ route('jobs.show', $rJob->slug) }}" class="text-decoration-none text-dark">{{ $rJob->title }}</a></h6>
                                <small class="text-muted">{{ $rJob->company->name }}</small>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-1 my-2">
                            <span class="badge-soft-success small" style="font-size: 11px;">{{ $rJob->salary_formatted }}</span>
                            <span class="badge-soft-primary small" style="font-size: 11px;">{{ $rJob->city }}</span>
                        </div>
                    </div>
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $rJob->job_type }}</small>
                        <a href="{{ route('jobs.show', $rJob->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Ứng tuyển</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
