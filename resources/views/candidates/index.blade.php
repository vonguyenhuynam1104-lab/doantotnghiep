@extends('layouts.app')

@section('title', 'Tìm Kiếm Nhân Tài & Ứng Viên Tiềm Năng - JobConnect')

@section('content')
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách ứng viên</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="card card-custom p-4 border shadow-sm mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-1 text-dark">Khám Phá Nhân Tài Hàng Đầu</h3>
                <p class="text-muted mb-0">Duyệt hồ sơ chuyên nghiệp của các ứng viên chất lượng cao sẵn sàng nhận việc.</p>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('candidates.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-md-7">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Chức danh, kỹ năng (Laravel, UI/UX...)...">
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
        @forelse($candidates as $candidate)
            <div class="col-xl-4 col-md-6">
                <div class="card card-custom h-100 p-4 border text-center">
                    @if($candidate->user->avatar)
                        <img src="{{ $candidate->user->avatar }}" alt="{{ $candidate->user->name }}" class="rounded-circle mx-auto mb-3 border shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold mx-auto mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 30px;">
                            {{ strtoupper(substr($candidate->user->name, 0, 1)) }}
                        </div>
                    @endif

                    <h5 class="fw-bold text-dark mb-1">
                        <a href="{{ route('candidates.show', $candidate->id) }}" class="text-decoration-none text-dark">
                            {{ $candidate->user->name }}
                        </a>
                    </h5>
                    <p class="text-primary small fw-semibold mb-2">{{ $candidate->title }}</p>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $candidate->city ?: 'Hà Nội' }} •
                        <i class="bi bi-briefcase me-1 text-primary"></i> {{ $candidate->experience_years }} năm KN
                    </p>

                    @if(!empty($candidate->skills_list))
                        <div class="d-flex flex-wrap justify-content-center gap-1 my-3" style="min-height: 52px;">
                            @foreach(array_slice($candidate->skills_list, 0, 4) as $s)
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">{{ $s }}</span>
                            @endforeach
                        </div>
                    @else
                        <div style="min-height: 52px;"></div>
                    @endif

                    <div class="mt-auto pt-3 border-top d-flex gap-2 justify-content-center">
                        <a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold">
                            Xem hồ sơ chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-people fs-1 text-muted"></i>
                <h5 class="fw-bold mt-2">Không tìm thấy ứng viên phù hợp</h5>
                <p class="text-muted">Vui lòng thử tìm kiếm lại với tiêu chí khác.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $candidates->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
