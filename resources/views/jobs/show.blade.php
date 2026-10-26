@extends('layouts.app')

@section('title', $job->title . ' - ' . $job->company->name . ' | JobConnect')

@section('content')
<!-- Page Breadcrumb -->
<div class="bg-white border-bottom py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}" class="text-decoration-none">Việc làm</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index', ['category' => $job->category->slug]) }}" class="text-decoration-none">{{ $job->category->name }}</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 300px;" aria-current="page">{{ $job->title }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <!-- Top Header Card -->
    <div class="card card-custom p-4 border shadow-sm mb-4">
        <div class="d-flex flex-column flex-md-row gap-4 align-items-start justify-content-between">
            <div class="d-flex gap-3 align-items-start">
                <a href="{{ route('companies.show', $job->company->slug) }}" class="flex-shrink-0">
                    <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="company-logo-img shadow-sm" style="width: 76px; height: 76px;">
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-1">{{ $job->title }}</h3>
                    <div class="mb-2">
                        <a href="{{ route('companies.show', $job->company->slug) }}" class="text-decoration-none text-muted fw-semibold fs-6">
                            <i class="bi bi-building me-1"></i> {{ $job->company->name }}
                        </a>
                        @if($job->company->is_verified)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-1">
                                <i class="bi bi-patch-check-fill"></i> Đã xác thực
                            </span>
                        @endif
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge-soft-success fs-6">
                            <i class="bi bi-cash-stack me-1"></i> {{ $job->salary_formatted }}
                        </span>
                        <span class="badge-soft-primary">
                            <i class="bi bi-geo-alt me-1"></i> {{ $job->city }}
                        </span>
                        <span class="badge-soft-purple">
                            <i class="bi bi-clock me-1"></i> {{ $job->job_type }}
                        </span>
                        <span class="badge-soft-warning">
                            <i class="bi bi-briefcase me-1"></i> {{ $job->experience_level }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                @if($hasApplied)
                    <button class="btn btn-success px-4 py-2 rounded-pill fw-bold" disabled>
                        <i class="bi bi-check2-circle me-1"></i> Đã nộp hồ sơ ({{ $myApplication->status_badge['label'] }})
                    </button>
                @else
                    <button type="button" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#applyJobModal">
                        <i class="bi bi-send-fill me-1"></i> Ứng tuyển ngay
                    </button>
                @endif

                <button class="btn btn-outline-danger btn-save-job px-3 py-2 rounded-pill fw-semibold {{ $isSaved ? 'btn-danger text-white' : '' }}" data-job-id="{{ $job->id }}">
                    <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
                    <span>{{ $isSaved ? 'Đã lưu' : 'Lưu tin' }}</span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top small text-muted">
            <div class="d-flex gap-3">
                <span><i class="bi bi-calendar-event me-1"></i> Hạn nộp hồ sơ: <strong class="text-dark">{{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Tuyển liên tục' }}</strong></span>
                <span><i class="bi bi-eye me-1"></i> Lượt xem: <strong>{{ $job->views_count }}</strong></span>
                <span><i class="bi bi-file-earmark-person me-1"></i> Đã ứng tuyển: <strong>{{ $job->applications->count() }}</strong></span>
            </div>
            <div>
                <i class="bi bi-clock-history me-1"></i> Đăng {{ $job->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    <!-- Application Status Alert if candidate already applied -->
    @if($hasApplied && $myApplication)
        <div class="alert alert-info rounded-4 border-0 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Bạn đã ứng tuyển vị trí này vào ngày {{ $myApplication->created_at->format('d/m/Y H:i') }}</h5>
                    <p class="mb-0 text-muted">Trạng thái hiện tại: <span class="badge {{ $myApplication->status_badge['class'] }}">{{ $myApplication->status_badge['label'] }}</span></p>
                    @if($myApplication->employer_note)
                        <div class="mt-2 p-2 bg-white rounded-3 border">
                            <strong class="text-dark"><i class="bi bi-chat-left-text me-1"></i> Lời nhắn từ nhà tuyển dụng:</strong> {{ $myApplication->employer_note }}
                        </div>
                    @endif
                    @if($myApplication->interview_at)
                        <div class="mt-2 p-2 bg-purple-subtle text-purple rounded-3 border border-purple-subtle">
                            <strong class="text-purple"><i class="bi bi-calendar-check me-1"></i> Lịch hẹn phỏng vấn:</strong> {{ $myApplication->interview_at->format('H:i, d/m/Y') }}
                        </div>
                    @endif
                </div>
                <a href="{{ route('candidate.applications') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                    Xem lịch sử nộp đơn
                </a>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Job Description -->
        <div class="col-lg-8">
            <div class="card card-custom p-4 border shadow-sm mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-file-text-fill text-primary me-2"></i>Mô Tả Công Việc</h5>
                <div class="text-secondary lh-lg mb-4" style="white-space: pre-line;">
                    {{ $job->description }}
                </div>

                @if($job->requirements)
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i>Yêu Cầu Ứng Viên</h5>
                    <div class="text-secondary lh-lg mb-4" style="white-space: pre-line;">
                        {{ $job->requirements }}
                    </div>
                @endif

                @if($job->benefits)
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-gift-fill text-success me-2"></i>Quyền Lợi Được Hưởng</h5>
                    <div class="text-secondary lh-lg mb-4" style="white-space: pre-line;">
                        {{ $job->benefits }}
                    </div>
                @endif

                <!-- Required Skills -->
                @if(!empty($job->skills_list))
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-tools text-warning me-2"></i>Kỹ Năng Cần Thiết</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($job->skills_list as $skill)
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fs-6 fw-normal">{{ $skill }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- Workplace Details -->
                <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Địa Điểm Làm Việc</h5>
                <p class="text-secondary mb-1"><i class="bi bi-building me-2"></i> {{ $job->address ?: $job->company->address ?: $job->city }}</p>
                <p class="text-secondary mb-4"><i class="bi bi-pin-map me-2"></i> Khu vực: {{ $job->city }}</p>

                <!-- Bottom Apply CTA -->
                <div class="p-4 rounded-4 bg-light border text-center mt-3">
                    <h5 class="fw-bold text-dark mb-2">Bạn thấy công việc này phù hợp với năng lực?</h5>
                    <p class="text-muted small mb-3">Nộp hồ sơ ngay để không bỏ lỡ cơ hội phỏng vấn từ {{ $job->company->name }}.</p>
                    @if($hasApplied)
                        <button class="btn btn-success px-4 py-2 rounded-pill fw-bold" disabled>
                            <i class="bi bi-check2-circle me-1"></i> Bạn đã nộp hồ sơ vị trí này
                        </button>
                    @else
                        <button type="button" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#applyJobModal">
                            <i class="bi bi-send-fill me-1"></i> Ứng tuyển ngay
                        </button>
                    @endif
                </div>
            </div>

            <!-- Other jobs from this company -->
            @if($companyOtherJobs->count() > 0)
                <div class="card card-custom p-4 border shadow-sm mb-4">
                    <h5 class="fw-bold text-dark mb-3">Việc Làm Khác Cùng Công Ty {{ $job->company->name }}</h5>
                    <div class="d-flex flex-column gap-3">
                        @foreach($companyOtherJobs as $oj)
                            <div class="p-3 border rounded-3 hover-shadow transition d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1"><a href="{{ route('jobs.show', $oj->slug) }}" class="text-decoration-none text-dark">{{ $oj->title }}</a></h6>
                                    <div class="small text-muted">
                                        <span class="text-success fw-bold">{{ $oj->salary_formatted }}</span> • {{ $oj->city }} • {{ $oj->job_type }}
                                    </div>
                                </div>
                                <a href="{{ route('jobs.show', $oj->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Xem</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Sidebar Info -->
        <div class="col-lg-4">
            <!-- Company Card -->
            <div class="card card-custom p-4 border shadow-sm mb-4 sticky-top" style="top: 85px; z-index: 5;">
                <div class="text-center mb-3">
                    <a href="{{ route('companies.show', $job->company->slug) }}">
                        <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="company-logo-img mb-3" style="width: 80px; height: 80px;">
                    </a>
                    <h5 class="fw-bold text-dark mb-1">
                        <a href="{{ route('companies.show', $job->company->slug) }}" class="text-decoration-none text-dark">
                            {{ $job->company->name }}
                        </a>
                    </h5>
                    @if($job->company->is_verified)
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 mt-1">
                            <i class="bi bi-patch-check-fill"></i> Nhà tuyển dụng uy tín
                        </span>
                    @endif
                </div>

                <hr class="my-3">

                <ul class="list-unstyled small d-flex flex-column gap-2 text-muted mb-4">
                    <li><i class="bi bi-people me-2 text-primary"></i> Quy mô: <strong class="text-dark">{{ $job->company->company_size ?: '50-150 nhân viên' }}</strong></li>
                    <li><i class="bi bi-briefcase me-2 text-primary"></i> Lĩnh vực: <strong class="text-dark">{{ $job->company->industry ?: 'Công nghệ / Phần mềm' }}</strong></li>
                    <li><i class="bi bi-geo-alt me-2 text-primary"></i> Trụ sở: <strong class="text-dark">{{ $job->company->city }}</strong></li>
                    @if($job->company->website)
                        <li><i class="bi bi-globe me-2 text-primary"></i> Website: <a href="{{ $job->company->website }}" target="_blank" class="text-decoration-none">{{ $job->company->website }}</a></li>
                    @endif
                </ul>

                <a href="{{ route('companies.show', $job->company->slug) }}" class="btn btn-outline-custom w-100 rounded-pill fw-semibold">
                    Xem trang thông tin công ty <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ứng tuyển Nhanh -->
<div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom p-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="applyJobModalLabel">Ứng Tuyển: {{ $job->title }}</h5>
                    <p class="text-muted small mb-0">{{ $job->company->name }} • {{ $job->city }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @guest
                <div class="modal-body p-5 text-center">
                    <div class="rounded-circle bg-primary-subtle text-primary p-3 d-inline-flex mb-3">
                        <i class="bi bi-person-lock fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Vui lòng đăng nhập để nộp hồ sơ</h5>
                    <p class="text-muted mb-4">Đăng nhập tài khoản Ứng viên để nộp hồ sơ trực tuyến, lưu việc làm và theo dõi phản hồi từ nhà tuyển dụng.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary-gradient px-4 py-2 rounded-pill">Đăng nhập</a>
                        <a href="{{ route('register') }}?role=candidate" class="btn btn-outline-custom px-4 py-2 rounded-pill">Tạo tài khoản mới</a>
                    </div>
                </div>
            @else
                @if(Auth::user()->isEmployer())
                    <div class="modal-body p-4 text-center">
                        <div class="alert alert-warning border-0 rounded-4">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i> Bạn đang đăng nhập với tư cách <strong>Nhà tuyển dụng</strong>. Chỉ tài khoản <strong>Ứng viên</strong> mới có thể nộp hồ sơ ứng tuyển.
                        </div>
                    </div>
                @else
                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="candidate_name" class="form-control" value="{{ old('candidate_name', Auth::user()->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Email liên hệ <span class="text-danger">*</span></label>
                                    <input type="email" name="candidate_email" class="form-control" value="{{ old('candidate_email', Auth::user()->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="candidate_phone" class="form-control" value="{{ old('candidate_phone', Auth::user()->phone) }}" required placeholder="09xxxxxxx">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Tải lên file CV mới (PDF, DOC, DOCX - Max 5MB)</label>
                                    <input type="file" name="resume_file" class="form-control" accept=".pdf,.doc,.docx">
                                    @if(Auth::user()->candidateProfile && Auth::user()->candidateProfile->resume_path)
                                        <small class="text-success"><i class="bi bi-check-circle"></i> Đã có CV trong hồ sơ cá nhân. Nếu không chọn file mới, hệ thống sẽ sử dụng CV sẵn có.</small>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Thư giới thiệu bản thân / Cover Letter</label>
                                    <textarea name="cover_letter" class="form-control" rows="4" placeholder="Giới thiệu ngắn gọn lý do bạn phù hợp với vị trí này, kinh nghiệm nổi bật..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top p-3">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary-gradient rounded-pill px-4 fw-bold">
                                <i class="bi bi-send-check me-1"></i> Gửi hồ sơ ứng tuyển
                            </button>
                        </div>
                    </form>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection
