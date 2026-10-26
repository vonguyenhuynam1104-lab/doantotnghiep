@extends('layouts.app')

@section('title', 'JobConnect - Nền Tảng Tìm Kiếm Việc Làm & Tuyển Dụng Nhân Tài')

@section('content')
<!-- Hero Section -->
<section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1e40af 100%);">
    <!-- Subtle background circle decorations -->
    <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl" style="width: 400px; height: 400px; top: -100px; right: -50px; filter: blur(80px);"></div>
    <div class="position-absolute rounded-circle bg-info opacity-20 blur-3xl" style="width: 300px; height: 300px; bottom: -50px; left: -50px; filter: blur(80px);"></div>

    <div class="container py-lg-4 position-relative z-1 text-center text-white">
        <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 rounded-pill px-3 py-2 mb-3 shadow-sm">
            <i class="bi bi-stars text-warning me-1"></i> Nền Tảng Kết Nối Tuyển Dụng Chuẩn Quốc Tế
        </span>
        <h1 class="display-4 fw-extrabold mb-3 text-white tracking-tight" style="font-weight: 800;">
            Chạm Tới Cơ Hội Nghề Nghiệp <br class="d-none d-md-block">
            <span style="background: linear-gradient(90deg, #60a5fa, #38bdf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Đột Phá Cùng JobConnect</span>
        </h1>
        <p class="lead text-slate-300 text-white-50 mx-auto mb-5" style="max-width: 680px;">
            Hơn 10.000+ cơ hội việc làm hấp dẫn từ các tập đoàn công nghệ và doanh nghiệp hàng đầu đang chào đón bạn.
        </p>

        <!-- Search Bar Card -->
        <div class="card p-3 p-md-4 border-0 rounded-4 shadow-lg text-dark mx-auto" style="max-width: 960px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(16px);">
            <form action="{{ route('jobs.index') }}" method="GET">
                <div class="row g-2 g-md-3 align-items-center">
                    <div class="col-lg-5 col-md-4 text-start">
                        <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-search text-primary me-1"></i> Vị trí / Kỹ năng / Công ty</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control bg-light border-0 py-2" placeholder="Ví dụ: Laravel, Marketing, UI/UX, FPT...">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 text-start">
                        <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-geo-alt text-danger me-1"></i> Địa điểm làm việc</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                            <select name="city" class="form-select bg-light border-0 py-2">
                                <option value="Tất cả địa điểm">Tất cả địa điểm</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Hải Phòng">Hải Phòng</option>
                                <option value="Cần Thơ">Cần Thơ</option>
                                <option value="Toàn quốc">Toàn quốc (Remote)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-3 mt-md-0">
                        <label class="form-label small d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary-gradient w-100 py-2 fs-6">
                            <i class="bi bi-search me-1"></i> Tìm việc ngay
                        </button>
                    </div>
                </div>
            </form>

            <!-- Popular search tags -->
            <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top text-start">
                <span class="small text-muted fw-bold"><i class="bi bi-fire text-danger me-1"></i> Tìm kiếm phổ biến:</span>
                <a href="{{ route('jobs.index', ['q' => 'Laravel']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">Laravel</a>
                <a href="{{ route('jobs.index', ['q' => 'React']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">React</a>
                <a href="{{ route('jobs.index', ['q' => 'Marketing']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">Marketing</a>
                <a href="{{ route('jobs.index', ['q' => 'UI/UX']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">UI/UX</a>
                <a href="{{ route('jobs.index', ['q' => 'DevOps']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">DevOps</a>
                <a href="{{ route('jobs.index', ['job_type' => 'Remote']) }}" class="badge bg-light text-dark text-decoration-none py-2 px-3 border rounded-pill">Làm việc từ xa</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Banner -->
<section class="py-4 bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="rounded-4 bg-primary-subtle text-primary p-3 fs-3">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="text-start">
                        <div class="h3 fw-bold mb-0 text-dark">{{ $stats['jobs'] }}+</div>
                        <small class="text-muted">Việc làm chất lượng cao</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="rounded-4 bg-success-subtle text-success p-3 fs-3">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="text-start">
                        <div class="h3 fw-bold mb-0 text-dark">{{ $stats['companies'] }}+</div>
                        <small class="text-muted">Doanh nghiệp hàng đầu</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="rounded-4 bg-warning-subtle text-warning p-3 fs-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="text-start">
                        <div class="h3 fw-bold mb-0 text-dark">{{ $stats['candidates'] }}+</div>
                        <small class="text-muted">Ứng viên tài năng</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="rounded-4 bg-info-subtle text-info p-3 fs-3">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <div class="text-start">
                        <div class="h3 fw-bold mb-0 text-dark">{{ $stats['applications'] }}+</div>
                        <small class="text-muted">Hồ sơ đã kết nối</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 mb-2">Ngành Nghề Nổi Bật</span>
                <h3 class="fw-bold mb-0">Khám Phá Việc Làm Theo Lĩnh Vực</h3>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn btn-outline-custom d-none d-sm-inline-flex align-items-center gap-1">
                Xem tất cả <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3 g-lg-4">
            @foreach($categories as $category)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('jobs.index', ['category' => $category->slug]) }}" class="text-decoration-none text-dark">
                        <div class="card card-custom h-100 p-4 border shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-primary-subtle text-primary p-3 fs-4 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                    <i class="bi {{ $category->icon ?: 'bi-briefcase' }}"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">{{ $category->name }}</h6>
                                    <span class="badge bg-light text-muted border rounded-pill">{{ $category->jobs_count }} vị trí đang tuyển</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Jobs Section -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 mb-2">
                    <i class="bi bi-fire text-danger"></i> Nhu Cầu Tuyển Dụng Cao
                </span>
                <h3 class="fw-bold mb-0">Việc Làm Nổi Bật Được Ứng Tuyển Nhiều</h3>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn btn-primary-gradient d-none d-sm-inline-flex align-items-center gap-1">
                Xem tất cả việc làm <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredJobs as $job)
                <div class="col-lg-6">
                    <div class="card card-custom p-4 h-100 border position-relative">
                        <div class="d-flex gap-3">
                            <a href="{{ route('companies.show', $job->company->slug) }}" class="flex-shrink-0">
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="company-logo-img shadow-sm">
                            </a>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <a href="{{ route('jobs.show', $job->slug) }}" class="text-decoration-none">
                                            <h5 class="fw-bold text-dark mb-1 hover-primary">{{ $job->title }}</h5>
                                        </a>
                                        <div class="text-muted small fw-medium mb-2">
                                            <a href="{{ route('companies.show', $job->company->slug) }}" class="text-decoration-none text-muted">
                                                <i class="bi bi-building me-1"></i> {{ $job->company->name }}
                                            </a>
                                            @if($job->company->is_verified)
                                                <i class="bi bi-patch-check-fill text-primary ms-1" title="Doanh nghiệp đã xác thực"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Save job button -->
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
                                </div>

                                <!-- Skill tags -->
                                @if(!empty($job->skills_list))
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($job->skills_list, 0, 4) as $skill)
                                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 11px;">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
                                    <span><i class="bi bi-calendar3 me-1"></i> Hạn nộp: {{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Tuyển liên tục' }}</span>
                                    <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                                        Ứng tuyển ngay <i class="bi bi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Top Companies Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 mb-2">Thương Hiệu Hàng Đầu</span>
                <h3 class="fw-bold mb-0">Nhà Tuyển Dụng Nổi Bật</h3>
            </div>
            <a href="{{ route('companies.index') }}" class="btn btn-outline-custom d-none d-sm-inline-flex align-items-center gap-1">
                Xem tất cả công ty <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($topCompanies as $comp)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-custom h-100 border overflow-hidden">
                        <div class="position-relative" style="height: 100px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); background-image: url('{{ $comp->cover_image }}'); background-size: cover; background-position: center;">
                            <div class="position-absolute w-100 h-100 bg-dark bg-opacity-25"></div>
                        </div>
                        <div class="p-4 pt-0 position-relative text-center">
                            <div class="mx-auto rounded-4 bg-white p-1 shadow-sm d-inline-block position-relative" style="margin-top: -36px;">
                                <img src="{{ $comp->logo_url }}" alt="{{ $comp->name }}" class="rounded-3" style="width: 72px; height: 72px; object-fit: cover;">
                            </div>
                            <h5 class="fw-bold text-dark mt-2 mb-1">
                                <a href="{{ route('companies.show', $comp->slug) }}" class="text-decoration-none text-dark">
                                    {{ $comp->name }}
                                </a>
                                @if($comp->is_verified)
                                    <i class="bi bi-patch-check-fill text-primary" title="Đã xác thực"></i>
                                @endif
                            </h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $comp->city }} • <i class="bi bi-people me-1 text-primary"></i> {{ $comp->company_size }}</p>
                            <p class="text-muted small text-truncate-2 mb-3" style="font-size: 13px;">
                                {{ Str::limit($comp->description, 95) }}
                            </p>
                            <a href="{{ route('companies.show', $comp->slug) }}" class="btn btn-light border w-100 rounded-pill fw-semibold py-2">
                                <span class="text-primary fw-bold">{{ $comp->jobs_count }}</span> việc làm đang mở <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to action Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);">
    <div class="container text-center text-white py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <span class="badge bg-white bg-opacity-10 text-white rounded-pill px-3 py-1 mb-3">Dành cho Doanh Nghiệp & Ứng Viên</span>
                <h2 class="fw-extrabold mb-3 text-white">Bạn Đang Tìm Kiếm Cơ Hội Mới Hay Cần Chiêu Mộ Nhân Tài?</h2>
                <p class="text-white-50 lead mb-4">
                    Gia nhập cộng đồng kết nối tuyển dụng uy tín hàng đầu. Trải nghiệm giải pháp kết nối nhanh chóng, minh bạch và hiệu quả cao.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('register') }}?role=candidate" class="btn btn-light btn-lg rounded-pill fw-bold px-4 py-3 shadow">
                        <i class="bi bi-person-badge text-primary me-2"></i> Tạo CV ứng viên ngay
                    </a>
                    <a href="{{ route('register') }}?role=employer" class="btn btn-outline-light btn-lg rounded-pill fw-bold px-4 py-3">
                        <i class="bi bi-megaphone me-2"></i> Đăng tin tuyển dụng (Miễn phí)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
