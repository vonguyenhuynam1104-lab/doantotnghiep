@extends('layouts.app')

@section('title', $company->name . ' - Hồ sơ công ty & Tuyển dụng | JobConnect')

@section('content')
<!-- Company Header Cover -->
<div class="position-relative" style="height: 240px; background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); background-image: url('{{ $company->cover_image }}'); background-size: cover; background-position: center;">
    <div class="position-absolute w-100 h-100" style="background: rgba(15, 23, 42, 0.65);"></div>
</div>

<div class="container" style="margin-top: -70px; position: relative; z-index: 2;">
    <div class="card card-custom p-4 border shadow-sm mb-4">
        <div class="d-flex flex-column flex-md-row gap-4 align-items-center align-items-md-end justify-content-between text-center text-md-start">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-center align-items-md-end">
                <div class="bg-white p-2 rounded-4 shadow-sm border" style="width: 120px; height: 120px;">
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-100 h-100 rounded-3" style="object-fit: cover;">
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        {{ $company->name }}
                        @if($company->is_verified)
                            <i class="bi bi-patch-check-fill text-primary fs-4" title="Doanh nghiệp đã xác thực"></i>
                        @endif
                    </h2>
                    <p class="text-muted mb-2">
                        <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $company->city }} •
                        <i class="bi bi-people me-1 text-primary"></i> {{ $company->company_size ?: '50-100 nhân viên' }} •
                        <i class="bi bi-briefcase me-1 text-warning"></i> {{ $company->industry ?: 'Công nghệ thông tin' }}
                    </p>
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" class="small text-primary text-decoration-none">
                            <i class="bi bi-globe me-1"></i> {{ $company->website }}
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Đang mở {{ $company->jobs_count }} vị trí tuyển dụng
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Company Overview -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 border shadow-sm mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Giới Thiệu Doanh Nghiệp</h5>
                <div class="text-secondary lh-lg mb-3" style="white-space: pre-line;">
                    {{ $company->description ?: 'Công ty hàng đầu trong lĩnh vực phát triển công nghệ và cung cấp giải pháp sáng tạo cho khách hàng.' }}
                </div>

                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 mt-4">Thông Tin Chi Tiết</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted mb-0">
                    <li><i class="bi bi-building me-2 text-primary"></i> Trụ sở chính: <strong class="text-dark">{{ $company->address ?: $company->city }}</strong></li>
                    <li><i class="bi bi-telephone me-2 text-primary"></i> Điện thoại: <strong class="text-dark">{{ $company->phone ?: 'Chưa cập nhật' }}</strong></li>
                    <li><i class="bi bi-envelope me-2 text-primary"></i> Email liên hệ: <strong class="text-dark">{{ $company->email ?: 'recruitment@' . $company->slug . '.vn' }}</strong></li>
                    <li><i class="bi bi-calendar3 me-2 text-primary"></i> Thành viên từ: <strong class="text-dark">{{ $company->created_at->format('m/Y') }}</strong></li>
                </ul>
            </div>
        </div>

        <!-- Open Jobs List -->
        <div class="col-lg-8">
            <div class="card card-custom p-4 border shadow-sm mb-4">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-briefcase-fill text-primary me-2"></i>Các Vị Trí Đang Tuyển Dụng ({{ $jobs->total() }})</h4>

                @forelse($jobs as $job)
                    <div class="p-3 border rounded-3 mb-3 hover-shadow transition">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <h5 class="fw-bold mb-1"><a href="{{ route('jobs.show', $job->slug) }}" class="text-decoration-none text-dark">{{ $job->title }}</a></h5>
                                <div class="d-flex flex-wrap gap-2 my-2">
                                    <span class="badge-soft-success"><i class="bi bi-cash-stack me-1"></i> {{ $job->salary_formatted }}</span>
                                    <span class="badge-soft-primary"><i class="bi bi-geo-alt me-1"></i> {{ $job->city }}</span>
                                    <span class="badge-soft-purple"><i class="bi bi-clock me-1"></i> {{ $job->job_type }}</span>
                                </div>
                            </div>
                            <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                Ứng tuyển ngay
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2"></i>
                        <p class="mt-2 mb-0">Công ty hiện chưa có tin tuyển dụng nào đang mở.</p>
                    </div>
                @endforelse

                <div class="mt-3 d-flex justify-content-center">
                    {{ $jobs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
