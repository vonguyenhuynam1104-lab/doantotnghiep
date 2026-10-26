@extends('layouts.dashboard')

@section('title', 'Lịch Sử Ứng Tuyển Việc Làm - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-send-check text-success me-2"></i>Danh Sách Việc Làm Đã Ứng Tuyển</h4>
            <p class="text-muted small mb-0">Theo dõi tiến độ xét duyệt hồ sơ và lịch phỏng vấn từ các công ty.</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary-gradient btn-sm rounded-pill fw-semibold px-3 py-2">
            <i class="bi bi-search me-1"></i> Tìm việc mới
        </a>
    </div>

    <!-- Status Tabs Filter -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('candidate.applications') }}" class="btn btn-sm {{ !request('status') || request('status') === 'all' ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
            Tất cả
        </a>
        <a href="{{ route('candidate.applications', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3">
            Chờ xét duyệt
        </a>
        <a href="{{ route('candidate.applications', ['status' => 'viewed']) }}" class="btn btn-sm {{ request('status') === 'viewed' ? 'btn-info text-white' : 'btn-outline-info' }} rounded-pill px-3">
            Đã xem hồ sơ
        </a>
        <a href="{{ route('candidate.applications', ['status' => 'interviewing']) }}" class="btn btn-sm {{ request('status') === 'interviewing' ? 'btn-purple text-white' : 'btn-outline-purple' }} rounded-pill px-3" style="border-color: #8b5cf6; {{ request('status') === 'interviewing' ? 'background-color: #8b5cf6;' : 'color: #8b5cf6;' }}">
            Mời phỏng vấn
        </a>
        <a href="{{ route('candidate.applications', ['status' => 'accepted']) }}" class="btn btn-sm {{ request('status') === 'accepted' ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3">
            Trúng tuyển
        </a>
        <a href="{{ route('candidate.applications', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') === 'rejected' ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-3">
            Từ chối
        </a>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($applications as $app)
            <div class="p-3 p-md-4 border rounded-4 bg-white hover-shadow transition">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div class="d-flex gap-3 align-items-start">
                        <img src="{{ $app->job->company->logo_url }}" alt="logo" class="company-logo-img flex-shrink-0" style="width: 60px; height: 60px;">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <a href="{{ route('jobs.show', $app->job->slug) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $app->job->title }}
                                </a>
                            </h5>
                            <div class="text-muted small mb-2">
                                <a href="{{ route('companies.show', $app->job->company->slug) }}" class="text-decoration-none text-muted">
                                    <i class="bi bi-building me-1"></i> {{ $app->job->company->name }}
                                </a>
                                <span class="mx-2">•</span>
                                <span class="text-secondary"><i class="bi bi-geo-alt me-1"></i> {{ $app->job->city }}</span>
                                <span class="mx-2">•</span>
                                <span class="text-success fw-bold">{{ $app->job->salary_formatted }}</span>
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-calendar-check me-1"></i> Nộp ngày: {{ $app->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="text-md-end w-100 w-md-auto">
                        <span class="badge {{ $app->status_badge['class'] }} border px-3 py-2 fs-6 rounded-pill">
                            {{ $app->status_badge['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Interview schedule notice -->
                @if($app->interview_at)
                    <div class="alert alert-purple border-0 rounded-3 mt-3 p-3 text-start" style="background-color: #faf5ff; border: 1px solid #e9d5ff !important; color: #581c87;">
                        <div class="fw-bold mb-1"><i class="bi bi-calendar-event-fill text-purple me-1"></i> Lịch hẹn phỏng vấn: {{ $app->interview_at->format('H:i - Ngày d/m/Y') }}</div>
                        <div class="small">Vui lòng chuẩn bị tinh thần và trang phục lịch sự. Nhà tuyển dụng sẽ chủ động liên hệ qua điện thoại hoặc email.</div>
                    </div>
                @endif

                <!-- Employer note -->
                @if($app->employer_note)
                    <div class="p-3 bg-light rounded-3 border mt-3 small text-secondary">
                        <strong class="text-dark"><i class="bi bi-chat-left-dots-fill text-primary me-1"></i> Phản hồi từ nhà tuyển dụng:</strong>
                        <p class="mb-0 mt-1">{{ $app->employer_note }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top small">
                    <div>
                        @if($app->resume_path)
                            <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="text-decoration-none text-primary fw-semibold">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Xem CV đã nộp
                            </a>
                        @else
                            <span class="text-muted"><i class="bi bi-file-earmark-person me-1"></i> Dùng hồ sơ trực tuyến</span>
                        @endif
                    </div>
                    <a href="{{ route('jobs.show', $app->job->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Chi tiết việc làm <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="rounded-circle bg-light d-inline-flex p-3 mb-2 text-muted">
                    <i class="bi bi-send-x fs-1"></i>
                </div>
                <h5 class="fw-bold">Chưa có đơn ứng tuyển nào</h5>
                <p class="text-muted">Bạn chưa nộp hồ sơ cho công việc nào ở mục này.</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary-gradient rounded-pill px-4">
                    Khám phá việc làm ngay
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $applications->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
