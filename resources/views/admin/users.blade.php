@extends('layouts.dashboard')

@section('title', 'Quản Lý Người Dùng - JobConnect Admin')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Quản Lý Người Dùng</h4>
            <p class="text-muted small mb-0">Quản lý tài khoản ứng viên, nhà tuyển dụng và quản trị viên.</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên, email, số điện thoại...">
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="all">Tất cả vai trò</option>
                        <option value="candidate" {{ request('role') === 'candidate' ? 'selected' : '' }}>Ứng viên</option>
                        <option value="employer" {{ request('role') === 'employer' ? 'selected' : '' }}>Nhà tuyển dụng</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
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
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Ngày tham gia</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="fw-bold text-dark">{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>{{ $user->phone ?: 'Chưa cập nhật' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill">Quản trị viên</span>
                            @elseif($user->role === 'employer')
                                <span class="badge bg-success rounded-pill">Nhà tuyển dụng</span>
                            @else
                                <span class="badge bg-primary rounded-pill">Ứng viên</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Hoạt động</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Đã khóa</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle_status', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill px-3">
                                        <i class="bi {{ $user->is_active ? 'bi-lock' : 'bi-unlock' }}"></i>
                                        {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-light text-muted border">Tài khoản của bạn</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
