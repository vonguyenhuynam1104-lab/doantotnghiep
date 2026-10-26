@extends('layouts.dashboard')

@section('title', 'Việc Làm Đã Lưu - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>Việc Làm Đã Lưu ({{ $savedJobs->total() }})</h4>
            <p class="text-muted small mb-0">Danh sách các vị trí bạn đã lưu để xem lại hoặc ứng tuyển sau.</p>
        </div>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
            <i class="bi bi-search me-1"></i> Tìm thêm việc làm
        </a>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse($savedJobs as $item)
            @php $job = $item->job; @endphp
            <div class="p-3 p-md-4 border rounded-4 bg-white hover-shadow transition">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div class="d-flex gap-3 align-items-start">
                        <img src="{{ $job->company->logo_url }}" alt="logo" class="company-logo-img flex-shrink-0" style="width: 56px; height: 56px;">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <a href="{{ route('jobs.show', $job->slug) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ $job->title }}
                                </a>
                            </h5>
                            <div class="text-muted small mb-2">
                                <a href="{{ route('companies.show', $job->company->slug) }}" class="text-decoration-none text-muted">
                                    <i class="bi bi-building me-1"></i> {{ $job->company->name }}
                                </a>
                                <span class="mx-2">•</span>
                                <span class="text-secondary"><i class="bi bi-geo-alt me-1"></i> {{ $job->city }}</span>
                                <span class="mx-2">•</span>
                                <span class="text-success fw-bold">{{ $job->salary_formatted }}</span>
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-calendar3 me-1"></i> Hạn nộp: {{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Tuyển liên tục' }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 w-100 w-md-auto justify-content-end">
                        <button class="btn btn-sm btn-outline-danger btn-save-job rounded-pill px-3" data-job-id="{{ $job->id }}">
                            <i class="bi bi-trash me-1"></i> Hủy lưu
                        </button>
                        <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-semibold">
                            Ứng tuyển ngay
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="rounded-circle bg-light d-inline-flex p-3 mb-2 text-danger">
                    <i class="bi bi-heart fs-1"></i>
                </div>
                <h5 class="fw-bold">Bạn chưa lưu việc làm nào</h5>
                <p class="text-muted">Khi tìm thấy công việc ưng ý, hãy nhấn nút hình trái tim để lưu lại vào đây.</p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary-gradient rounded-pill px-4">
                    Khám phá việc làm ngay
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $savedJobs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
