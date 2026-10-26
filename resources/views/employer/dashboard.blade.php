@extends('layouts.dashboard')

@section('title', 'Bảng Điều Khiển Nhà Tuyển Dụng - JobConnect')

@section('dashboard_content')
<!-- Header Card -->
<div class="card card-custom p-4 border shadow-sm mb-4" style="background: linear-gradient(135deg, #065f46, #10b981); color: white;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-white">{{ $company->name }}</h4>
            <p class="mb-0 text-white-50">Chào mừng bạn đến với Cổng quản trị tuyển dụng và kết nối nhân tài.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-light rounded-pill fw-semibold px-4 py-2 text-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Đăng tin mới
            </a>
            <a href="{{ route('companies.show', $company->slug) }}" class="btn btn-outline-light rounded-pill fw-semibold px-3 py-2">
                <i class="bi bi-eye me-1"></i> Trang công ty
            </a>
        </div>
    </div>
</div>

<!-- Stats Counter Grid -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-primary-subtle text-primary p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-briefcase fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['active_jobs'] }} / {{ $stats['total_jobs'] }}</h3>
            <small class="text-muted">Tin đang hiển thị</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-info-subtle text-info p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-inbox fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['total_applications'] }}</h3>
            <small class="text-muted">Tổng hồ sơ nhận được</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-warning-subtle text-warning p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center;">
                <i class="bi bi-hourglass-split fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['pending_applications'] }}</h3>
            <small class="text-muted">Hồ sơ chờ xem xét</small>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 border shadow-sm text-center">
            <div class="rounded-circle bg-purple-subtle text-purple p-2 d-inline-flex mx-auto mb-2" style="width: 48px; height: 48px; align-items: center; justify-content: center; background-color: #f3e8ff; color: #7e22ce;">
                <i class="bi bi-calendar-check fs-5"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">{{ $stats['interviewing'] }}</h3>
            <small class="text-muted">Đang hẹn phỏng vấn</small>
        </div>
    </div>
</div>

<!-- Recent Applications Table -->
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-primary me-2"></i>Ứng Viên Mới Nộp Hồ Sơ</h5>
        <a href="{{ route('employer.applications.index') }}" class="small text-primary text-decoration-none fw-semibold">Xem toàn bộ hồ sơ</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ứng viên</th>
                    <th>Vị trí ứng tuyển</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentApplications as $app)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $app->candidate_name }}</div>
                            <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $app->candidate_email }} • <i class="bi bi-phone me-1"></i> {{ $app->candidate_phone }}</small>
                        </td>
                        <td>
                            <span class="fw-semibold text-secondary">{{ $app->job->title }}</span>
                        </td>
                        <td class="small text-muted">{{ $app->created_at->diffForHumans() }}</td>
                        <td>
                            <span class="badge {{ $app->status_badge['class'] }} border">
                                {{ $app->status_badge['label'] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('employer.applications.index', ['job_id' => $app->job_posting_id]) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Chưa có ứng viên nào nộp hồ sơ gần đây.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Active Jobs Quick View -->
<div class="card card-custom p-4 border shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-check text-success me-2"></i>Tin Tuyển Dụng Đang Mở</h5>
        <a href="{{ route('employer.jobs.index') }}" class="small text-primary text-decoration-none fw-semibold">Quản lý tin</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tiêu đề công việc</th>
                    <th>Lương</th>
                    <th>Hạn nộp</th>
                    <th>Lượt xem</th>
                    <th>Hồ sơ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeJobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job->slug) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $job->title }}
                            </a>
                            <div class="small text-muted">{{ $job->city }} • {{ $job->job_type }}</div>
                        </td>
                        <td class="text-success fw-bold small">{{ $job->salary_formatted }}</td>
                        <td class="small text-muted">{{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Không giới hạn' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $job->views_count }}</span></td>
                        <td><span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span></td>
                        <td>
                            <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-light border rounded-pill me-1" title="Chỉnh sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Xem hồ sơ">
                                Xem CV
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Chưa có tin tuyển dụng nào. <a href="{{ route('employer.jobs.create') }}">Đăng tin ngay</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
