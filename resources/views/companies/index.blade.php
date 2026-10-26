@extends('layouts.app')

@section('title', 'Danh Sách Công Ty Hàng Đầu - JobConnect')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách công ty</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="card card-custom p-4 border shadow-sm mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-1 text-dark">Khám Phá Doanh Nghiệp Hàng Đầu</h3>
                <p class="text-muted mb-0">Tìm hiểu môi trường làm việc, văn hóa doanh nghiệp và các vị trí đang tuyển dụng.</p>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('companies.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tên công ty, lĩnh vực...">
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <select name="city" class="form-select">
                                    <option value="Tất cả">Tất cả địa điểm</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($companies as $company)
            <div class="col-xl-4 col-md-6">
                <div class="card card-custom h-100 border overflow-hidden">
                    <div class="position-relative" style="height: 110px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); background-image: url('{{ $company->cover_image }}'); background-size: cover; background-position: center;">
                        <div class="position-absolute w-100 h-100 bg-dark bg-opacity-25"></div>
                    </div>
                    <div class="p-4 pt-0 text-center position-relative">
                        <div class="mx-auto rounded-4 bg-white p-1 shadow-sm d-inline-block position-relative" style="margin-top: -40px;">
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="rounded-3" style="width: 76px; height: 76px; object-fit: cover;">
                        </div>
                        <h5 class="fw-bold text-dark mt-2 mb-1">
                            <a href="{{ route('companies.show', $company->slug) }}" class="text-decoration-none text-dark">
                                {{ $company->name }}
                            </a>
                            @if($company->is_verified)
                                <i class="bi bi-patch-check-fill text-primary" title="Đã xác thực"></i>
                            @endif
                        </h5>
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $company->city }} • {{ $company->company_size ?: '50-100 nhân viên' }}</p>
                        <p class="text-muted small mb-3" style="min-height: 40px;">
                            {{ Str::limit($company->description, 90) ?: 'Môi trường làm việc năng động, chuyên nghiệp cùng nhiều cơ hội thăng tiến.' }}
                        </p>
                        <a href="{{ route('companies.show', $company->slug) }}" class="btn btn-outline-primary rounded-pill w-100 fw-semibold py-2">
                            <span>{{ $company->jobs_count }} việc làm đang tuyển</span> <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-buildings fs-1 text-muted"></i>
                <h5 class="fw-bold mt-2">Không tìm thấy công ty phù hợp</h5>
                <p class="text-muted">Vui lòng thử tìm kiếm với từ khóa khác.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $companies->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
