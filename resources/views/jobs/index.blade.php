@extends('layouts.app')

@section('title', 'Tìm Kiếm Việc Làm Toàn Quốc - JobConnect')

@section('content')
<!-- Page Header Breadcrumb -->
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách việc làm</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <form action="{{ route('jobs.index') }}" method="GET" id="filterForm">
        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="card card-custom p-4 border shadow-sm sticky-top" style="top: 85px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill text-primary me-2"></i>Bộ Lọc Tuyển Dụng</h6>
                        <a href="{{ route('jobs.index') }}" class="small text-danger text-decoration-none fw-semibold">Xóa bộ lọc</a>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Từ khóa</label>
                        <div class="input-group">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tên công việc, kỹ năng...">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Ngành nghề</label>
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả ngành nghề</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->jobs_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Địa điểm</label>
                        <select name="city" class="form-select" onchange="this.form.submit()">
                            <option value="Tất cả địa điểm">Tất cả địa điểm</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Job Type Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Hình thức làm việc</label>
                        <div class="d-flex flex-column gap-1">
                            @foreach(['all' => 'Tất cả hình thức', 'Full-time' => 'Full-time', 'Part-time' => 'Part-time', 'Remote' => 'Remote (Từ xa)', 'Internship' => 'Thực tập sinh (Intern)'] as $key => $val)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="job_type" id="type_{{ $key }}" value="{{ $key }}" {{ (request('job_type', 'all') == $key) ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label small" for="type_{{ $key }}">{{ $val }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Experience Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Cấp bậc / Kinh nghiệm</label>
                        <select name="experience_level" class="form-select" onchange="this.form.submit()">
                            <option value="all">Tất cả cấp bậc</option>
                            <option value="Thực tập sinh" {{ request('experience_level') == 'Thực tập sinh' ? 'selected' : '' }}>Thực tập sinh</option>
                            <option value="Mới tốt nghiệp / Fresher" {{ request('experience_level') == 'Mới tốt nghiệp / Fresher' ? 'selected' : '' }}>Mới tốt nghiệp / Fresher</option>
                            <option value="Nhân viên / Junior-Middle" {{ request('experience_level') == 'Nhân viên / Junior-Middle' ? 'selected' : '' }}>Nhân viên / Junior-Middle</option>
                            <option value="Trưởng nhóm / Senior" {{ request('experience_level') == 'Trưởng nhóm / Senior' ? 'selected' : '' }}>Trưởng nhóm / Senior</option>
                            <option value="Quản lý / Trưởng phòng" {{ request('experience_level') == 'Quản lý / Trưởng phòng' ? 'selected' : '' }}>Quản lý / Trưởng phòng</option>
                        </select>
                    </div>

                    <!-- Salary Range Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mức thu nhập</label>
                        <div class="d-flex flex-column gap-1">
                            @foreach([
                                '' => 'Tất cả mức lương',
                                'under_10m' => 'Dưới 10 triệu',
                                '10m_20m' => '10 - 25 triệu',
                                '20m_35m' => '20 - 40 triệu',
                                'above_35m' => 'Trên 35 triệu',
                                'negotiable' => 'Thương lượng'
                            ] as $rKey => $rLabel)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salary_range" id="sal_{{ $rKey }}" value="{{ $rKey }}" {{ request('salary_range') == $rKey ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label small" for="sal_{{ $rKey }}">{{ $rLabel }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-gradient w-100 rounded-pill mt-2">
                        <i class="bi bi-filter"></i> Áp dụng bộ lọc
                    </button>
                </div>
            </div>

            <!-- Main Results Column -->
            <div class="col-lg-9">
                <!-- Results Header Bar -->
                <div class="card card-custom p-3 border shadow-sm mb-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <div>
                            <span class="fw-bold text-dark fs-5">Tìm thấy <span class="text-primary">{{ $jobs->total() }}</span> việc làm phù hợp</span>
                            @if(request('q'))
                                <span class="text-muted small">với từ khóa "<strong>{{ request('q') }}</strong>"</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="small text-muted fw-bold text-nowrap">Sắp xếp theo:</label>
                            <select name="sort" class="form-select form-select-sm" style="width: 170px;" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="salary_desc" {{ request('sort') == 'salary_desc' ? 'selected' : '' }}>Lương cao nhất</option>
                                <option value="views_desc" {{ request('sort') == 'views_desc' ? 'selected' : '' }}>Xem nhiều nhất</option>
                                <option value="deadline_asc" {{ request('sort') == 'deadline_asc' ? 'selected' : '' }}>Sắp hết hạn</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Job Postings List -->
                @forelse($jobs as $job)
                    <div class="card card-custom p-4 border shadow-sm mb-3">
                        <div class="d-flex gap-3">
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="flex-shrink-0">
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="company-logo-img shadow-sm">
                            </a>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-decoration-none">
                                            <h5 class="fw-bold text-dark mb-1">{{ $job->title }}</h5>
                                        </a>
                                        <div class="text-muted small fw-medium mb-2">
                                            <a href="{{ route('companies.show', $job->company->slug) }}" class="text-decoration-none text-muted">
                                                <i class="bi bi-building me-1"></i> {{ $job->company->name }}
                                            </a>
                                            @if($job->company->is_verified)
                                                <i class="bi bi-patch-check-fill text-primary ms-1" title="Doanh nghiệp đã xác thực"></i>
                                            @endif
                                            <span class="mx-2">•</span>
                                            <span class="text-secondary"><i class="bi bi-tag me-1"></i> {{ $job->category->name }}</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger btn-save-job rounded-circle p-2 {{ $job->isSavedBy() ? 'btn-danger text-white' : '' }}" data-job-id="{{ $job->id }}" title="Lưu việc làm">
                                        <i class="bi {{ $job->isSavedBy() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </div>

                                <div class="d-flex flex-wrap gap-2 my-2">
                                    <span class="badge-soft-success">
                                        <i class="bi bi-cash-stack me-1"></i> {{ $job->salary_formatted }}
                                    </span>
                                    <span class="badge-soft-primary">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $job->city }}
                                    </span>
                                    <span class="badge-soft-purple">
                                        <i class="bi bi-clock me-1"></i> {{ $job->job_type }}
                                    </span>
                                    <span class="badge-soft-warning">
                                        <i class="bi bi-person-workspace me-1"></i> {{ $job->experience_level }}
                                    </span>
                                </div>

                                <!-- Skills required tags -->
                                @if(!empty($job->skills_list))
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($job->skills_list, 0, 5) as $skill)
                                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
                                    <span>
                                        <i class="bi bi-clock-history me-1"></i> Đăng {{ $job->created_at->diffForHumans() }}
                                        @if($job->deadline)
                                            • <i class="bi bi-hourglass-split text-danger me-1"></i> Hạn: {{ $job->deadline->format('d/m/Y') }}
                                        @endif
                                    </span>
                                    <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-semibold">
                                        Xem chi tiết & Ứng tuyển <i class="bi bi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card card-custom p-5 text-center border">
                        <div class="rounded-circle bg-light d-inline-flex p-4 mx-auto mb-3 text-muted">
                            <i class="bi bi-inbox fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Không tìm thấy việc làm phù hợp</h5>
                        <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bỏ bớt các tiêu chí lọc trong thanh bên trái.</p>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary rounded-pill px-4 mx-auto">
                            Xem tất cả việc làm
                        </a>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $jobs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
