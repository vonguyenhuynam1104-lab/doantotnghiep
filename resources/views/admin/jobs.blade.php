@extends('layouts.dashboard')

@section('title', 'Quản Lý Tất Cả Việc Làm - JobConnect Admin')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-text-fill text-primary me-2"></i>Quản Lý Tin Tuyển Dụng</h4>
            <p class="text-muted small mb-0">Kiểm duyệt và giám sát toàn bộ tin tuyển dụng đăng tải trên nền tảng.</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <form action="{{ route('admin.jobs') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm kiếm theo tiêu đề công việc...">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all">Tất cả trạng thái</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đang hiển thị</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                    </select>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tiêu đề công việc</th>
                    <th>Công ty</th>
                    <th>Ngành nghề</th>
                    <th>Lương</th>
                    <th>Lượt xem</th>
                    <th>Hồ sơ</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none hover-primary">
                                {{ $job->title }}
                            </a>
                            <div class="small text-muted">{{ $job->city }} • {{ $job->job_type }}</div>
                        </td>
                        <td>{{ $job->company->name }}</td>
                        <td class="small">{{ $job->category->name }}</td>
                        <td class="small text-success fw-bold">{{ $job->salary_formatted }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $job->views_count }}</span></td>
                        <td><span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span></td>
                        <td>
                            <span class="badge {{ $job->status === 'published' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary' }} rounded-pill">
                                {{ $job->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này khỏi hệ thống?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Xóa bỏ">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
