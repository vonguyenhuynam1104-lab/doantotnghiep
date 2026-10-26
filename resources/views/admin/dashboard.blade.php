@extends('layouts.dashboard')

@section('title', 'Bảng Quản Trị Hệ Thống - JobConnect Admin')

@section('dashboard_content')
<!-- Header Card -->
<div class="card card-custom p-4 border shadow-sm mb-4" style="background: linear-gradient(135deg, #1e1b4b, #312e81); color: white;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-white">Quản Trị Hệ Thống JobConnect</h4>
            <p class="mb-0 text-white-50">Giám sát tổng thể hoạt động, người dùng, tin tuyển dụng và hồ sơ kết nối.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success rounded-pill px-3 py-2 d-flex align-items-center gap-1">
                <i class="bi bi-circle-fill" style="font-size: 8px;"></i> Hệ thống hoạt động tốt
            </span>
        </div>
    </div>
</div>

<!-- Stats Counter Grid -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-primary-subtle text-primary p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-people fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['total_users'] }}</h3>
            <small class="text-muted">{{ $stats['candidates_count'] }} ứng viên • {{ $stats['employers_count'] }} NTD</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-success-subtle text-success p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-buildings fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['companies_count'] }}</h3>
            <small class="text-muted">Doanh nghiệp đã đăng ký</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-warning-subtle text-warning p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-briefcase fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['jobs_count'] }}</h3>
            <small class="text-muted">{{ $stats['active_jobs_count'] }} tin đang hiển thị</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-info-subtle text-info p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-file-earmark-check fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['applications_count'] }}</h3>
            <small class="text-muted">Tổng lượt nộp hồ sơ</small>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Users -->
    <div class="col-lg-6">
        <div class="card card-custom p-4 border shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-plus text-primary me-2"></i>Thành Viên Mới Đăng Ký</h5>
                <a href="{{ route('admin.users') }}" class="small text-primary text-decoration-none fw-semibold">Quản lý</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $u)
                            <tr>
                                <td class="fw-bold text-dark">{{ $u->name }}</td>
                                <td class="text-muted">{{ $u->email }}</td>
                                <td>
                                    @if($u->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($u->role === 'employer')
                                        <span class="badge bg-success">NTD</span>
                                    @else
                                        <span class="badge bg-primary">Ứng viên</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $u->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $u->is_active ? 'Hoạt động' : 'Bị khóa' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Jobs -->
    <div class="col-lg-6">
        <div class="card card-custom p-4 border shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-briefcase text-success me-2"></i>Tin Tuyển Dụng Mới Nhất</h5>
                <a href="{{ route('admin.jobs') }}" class="small text-primary text-decoration-none fw-semibold">Quản lý</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Công ty</th>
                            <th>Địa điểm</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentJobs as $rj)
                            <tr>
                                <td class="fw-bold text-dark">
                                    <a href="{{ route('jobs.show', $rj->slug) }}" class="text-decoration-none text-dark">{{ Str::limit($rj->title, 26) }}</a>
                                </td>
                                <td class="text-muted">{{ Str::limit($rj->company->name, 20) }}</td>
                                <td>{{ $rj->city }}</td>
                                <td>
                                    <span class="badge {{ $rj->status === 'published' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $rj->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
