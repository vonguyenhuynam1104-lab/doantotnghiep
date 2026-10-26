@extends('layouts.dashboard')

@section('title', 'Quản Lý Tin Tuyển Dụng - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-list-check text-primary me-2"></i>Danh Sách Tin Tuyển Dụng</h4>
            <p class="text-muted small mb-0">Quản lý các vị trí tuyển dụng, theo dõi lượt ứng tuyển và trạng thái hiển thị.</p>
        </div>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary-gradient rounded-pill fw-semibold px-3 py-2">
            <i class="bi bi-plus-circle me-1"></i> Đăng tin mới
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="row g-2 mb-3">
        <div class="col-md-8">
            <form action="{{ route('employer.jobs.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tiêu đề công việc...">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ route('employer.jobs.index') }}" method="GET" id="statusFilterForm">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đang hiển thị</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tiêu đề công việc</th>
                    <th>Ngành nghề</th>
                    <th>Lương</th>
                    <th>Hạn nộp</th>
                    <th>Lượt xem</th>
                    <th>Ứng viên</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job->slug) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                {{ $job->title }}
                            </a>
                            <div class="small text-muted">{{ $job->city }} • {{ $job->job_type }}</div>
                        </td>
                        <td class="small">{{ $job->category->name }}</td>
                        <td class="small text-success fw-bold">{{ $job->salary_formatted }}</td>
                        <td class="small text-muted">{{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Không thời hạn' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $job->views_count }}</span></td>
                        <td>
                            <a href="{{ route('employer.applications.index', ['job_id' => $job->id]) }}" class="badge bg-primary text-decoration-none rounded-pill px-2 py-1">
                                {{ $job->applications_count }} hồ sơ
                            </a>
                        </td>
                        <td>
                            @if($job->status === 'published')
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Đang hiển thị</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Đã đóng</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('employer.jobs.toggle_status', $job->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="{{ $job->status === 'published' ? 'Đóng tin tuyển dụng' : 'Mở lại tin tuyển dụng' }}">
                                        <i class="bi {{ $job->status === 'published' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('employer.jobs.delete', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa tin">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Chưa có tin tuyển dụng nào phù hợp. <a href="{{ route('employer.jobs.create') }}">Đăng tin ngay</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
