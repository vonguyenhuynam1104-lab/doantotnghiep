@extends('layouts.dashboard')

@section('title', 'Quản Lý Hồ Sơ Ứng Tuyển - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-inbox-fill text-primary me-2"></i>Danh Sách Hồ Sơ Ứng Tuyển</h4>
            <p class="text-muted small mb-0">Xem xét CV ứng viên, cập nhật trạng thái xét duyệt và lên lịch phỏng vấn.</p>
        </div>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('employer.applications.index') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <select name="job_id" class="form-select" onchange="this.form.submit()">
                    <option value="all">Tất cả vị trí tuyển dụng</option>
                    @foreach($companyJobs as $cj)
                        <option value="{{ $cj->id }}" {{ request('job_id') == $cj->id ? 'selected' : '' }}>{{ $cj->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="all">Tất cả trạng thái hồ sơ</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xét duyệt</option>
                    <option value="viewed" {{ request('status') === 'viewed' ? 'selected' : '' }}>Đã xem hồ sơ</option>
                    <option value="interviewing" {{ request('status') === 'interviewing' ? 'selected' : '' }}>Mời phỏng vấn</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Trúng tuyển</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Applications List -->
    <div class="d-flex flex-column gap-3">
        @forelse($applications as $app)
            <div class="p-4 border rounded-4 bg-white hover-shadow transition">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="fw-bold text-dark mb-0">{{ $app->candidate_name }}</h5>
                            <span class="badge {{ $app->status_badge['class'] }} border">
                                {{ $app->status_badge['label'] }}
                            </span>
                        </div>
                        <p class="text-primary fw-semibold small mb-2">
                            Ứng tuyển: <a href="{{ route('jobs.show', $app->job->slug) }}" class="text-decoration-none text-primary">{{ $app->job->title }}</a>
                        </p>
                        <div class="d-flex flex-wrap gap-3 small text-muted">
                            <span><i class="bi bi-envelope me-1"></i> {{ $app->candidate_email }}</span>
                            <span><i class="bi bi-telephone me-1"></i> {{ $app->candidate_phone }}</span>
                            <span><i class="bi bi-clock me-1"></i> Nộp ngày: {{ $app->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 w-100 w-md-auto justify-content-end">
                        @if($app->resume_path)
                            <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Xem CV
                            </a>
                        @elseif($app->candidate && $app->candidate->candidateProfile)
                            <a href="{{ route('candidates.show', $app->candidate->candidateProfile->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-person me-1"></i> Xem Profile
                            </a>
                        @endif

                        <button type="button" class="btn btn-sm btn-primary-gradient rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal_{{ $app->id }}">
                            <i class="bi bi-sliders me-1"></i> Xử lý hồ sơ
                        </button>
                    </div>
                </div>

                <!-- Cover letter preview if present -->
                @if($app->cover_letter)
                    <div class="mt-3 p-3 bg-light rounded-3 border small">
                        <strong class="text-dark"><i class="bi bi-chat-quote-fill text-muted me-1"></i> Thư giới thiệu của ứng viên:</strong>
                        <p class="text-secondary mb-0 mt-1" style="white-space: pre-line;">{{ $app->cover_letter }}</p>
                    </div>
                @endif

                <!-- Interview or Note notice -->
                @if($app->interview_at || $app->employer_note)
                    <div class="mt-3 p-3 bg-primary-subtle rounded-3 border border-primary-subtle small">
                        @if($app->interview_at)
                            <div class="text-purple fw-bold mb-1"><i class="bi bi-calendar-check me-1"></i> Đã hẹn phỏng vấn: {{ $app->interview_at->format('H:i - Ngày d/m/Y') }}</div>
                        @endif
                        @if($app->employer_note)
                            <div class="text-dark"><strong>Ghi chú/Phản hồi cho ứng viên:</strong> {{ $app->employer_note }}</div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Modal Xử lý Hồ sơ -->
            <div class="modal fade" id="reviewModal_{{ $app->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header border-bottom p-3">
                            <h5 class="modal-title fw-bold text-dark">Xử Lý Đơn Ứng Tuyển</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('employer.applications.update_status', $app->id) }}" method="POST">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Ứng viên: <strong class="text-dark">{{ $app->candidate_name }}</strong></label>
                                    <br>
                                    <small class="text-muted">Vị trí: {{ $app->job->title }}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Trạng thái hồ sơ <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Chờ xét duyệt</option>
                                        <option value="viewed" {{ $app->status === 'viewed' ? 'selected' : '' }}>Đã xem hồ sơ</option>
                                        <option value="interviewing" {{ $app->status === 'interviewing' ? 'selected' : '' }}>Mời phỏng vấn</option>
                                        <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Trúng tuyển / Đã tuyển</option>
                                        <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Lịch hẹn phỏng vấn (Nếu có)</label>
                                    <input type="datetime-local" name="interview_at" class="form-control" value="{{ $app->interview_at ? $app->interview_at->format('Y-m-d\TH:i') : '' }}">
                                    <small class="text-muted">Ứng viên sẽ nhìn thấy lịch này trên bảng điều khiển cá nhân.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Ghi chú hoặc Lời nhắn gửi ứng viên</label>
                                    <textarea name="employer_note" class="form-control" rows="3" placeholder="Nhập phản hồi, địa điểm phỏng vấn hoặc lời nhắn cho ứng viên...">{{ $app->employer_note }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-top p-3">
                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary-gradient rounded-pill px-4 fw-bold">
                                    <i class="bi bi-check2-circle me-1"></i> Lưu trạng thái
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="fw-bold mt-2">Chưa có hồ sơ ứng tuyển nào</h5>
                <p class="text-muted">Hồ sơ ứng viên nộp vào tin tuyển dụng của công ty sẽ hiển thị tại đây.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $applications->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
