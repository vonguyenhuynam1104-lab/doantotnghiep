@extends('layouts.dashboard')

@section('title', 'Quản Lý Doanh Nghiệp - JobConnect Admin')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-buildings text-primary me-2"></i>Quản Lý Doanh Nghiệp</h4>
            <p class="text-muted small mb-0">Xác thực doanh nghiệp chính chủ và giám sát các nhà tuyển dụng trên hệ thống.</p>
        </div>
    </div>

    <!-- Search -->
    <form action="{{ route('admin.companies') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-9">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên công ty, địa điểm...">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Tìm kiếm</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Công ty</th>
                    <th>Tài khoản sở hữu</th>
                    <th>Trụ sở</th>
                    <th>Số tin tuyển</th>
                    <th>Xác thực (Verified)</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $company->logo_url }}" alt="logo" class="company-logo-img" style="width: 44px; height: 44px;">
                                <div>
                                    <div class="fw-bold text-dark">
                                        <a href="{{ route('companies.show', $company->slug) }}" target="_blank" class="text-decoration-none text-dark">
                                            {{ $company->name }}
                                        </a>
                                    </div>
                                    <small class="text-muted">{{ $company->industry }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="small">
                            <div>{{ $company->user->name }}</div>
                            <div class="text-muted">{{ $company->user->email }}</div>
                        </td>
                        <td class="small">{{ $company->city }}</td>
                        <td><span class="badge bg-primary rounded-pill">{{ $company->jobs_count }} tin</span></td>
                        <td>
                            @if($company->is_verified)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                    <i class="bi bi-patch-check-fill"></i> Đã xác thực
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                    Chưa xác thực
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.companies.toggle_verified', $company->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $company->is_verified ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-pill px-3">
                                    <i class="bi {{ $company->is_verified ? 'bi-shield-x' : 'bi-shield-check' }}"></i>
                                    {{ $company->is_verified ? 'Hủy xác thực' : 'Cấp tích xanh' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $companies->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
