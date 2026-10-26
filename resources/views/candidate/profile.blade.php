@extends('layouts.dashboard')

@section('title', 'Quản Lý CV & Hồ Sơ Cá Nhân - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>Quản Lý CV & Hồ Sơ Cá Nhân</h4>
            <p class="text-muted small mb-0">Hồ sơ hoàn chỉnh sẽ tăng 80% cơ hội được nhà tuyển dụng chủ động liên hệ.</p>
        </div>
        @if($profile->resume_path)
            <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-file-earmark-pdf me-1"></i> Xem CV hiện tại
            </a>
        @endif
    </div>

    <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <!-- Avatar & General Info -->
            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Chức danh nghề nghiệp <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $profile->title) }}" required placeholder="Ví dụ: Senior Laravel Developer">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Địa chỉ Email (Đăng nhập)</label>
                <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Số điện thoại liên hệ</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="09xxxxxxx">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Số năm kinh nghiệm</label>
                <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $profile->experience_years) }}" min="0" max="50">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Mức lương mong muốn</label>
                <input type="text" name="expected_salary" class="form-control" value="{{ old('expected_salary', $profile->expected_salary) }}" placeholder="Ví dụ: 20 - 30 Triệu">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Tỉnh / Thành phố</label>
                <select name="city" class="form-select">
                    <option value="">Chọn địa điểm</option>
                    @foreach(['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ', 'Toàn quốc'] as $c)
                        <option value="{{ $c }}" {{ old('city', $profile->city) === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Địa chỉ cư trú chi tiết</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $profile->address) }}" placeholder="Quận/Huyện, Tỉnh/Thành...">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Kỹ năng chuyên môn (cách nhau bằng dấu phẩy)</label>
                <input type="text" name="skills" class="form-control" value="{{ old('skills', $profile->skills) }}" placeholder="PHP, Laravel, Vue.js, MySQL, Docker, RESTful API...">
                <small class="text-muted">Nhập các kỹ năng chính để nhà tuyển dụng dễ dàng tìm thấy bạn khi lọc từ khóa.</small>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Trình độ học vấn & Bằng cấp</label>
                <input type="text" name="education" class="form-control" value="{{ old('education', $profile->education) }}" placeholder="Ví dụ: Cử nhân Công nghệ Thông tin - Đại học Bách Khoa Hà Nội">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Giới thiệu bản thân & Mục tiêu nghề nghiệp</label>
                <textarea name="bio" class="form-control" rows="4" placeholder="Tóm tắt kinh nghiệm làm việc, thế mạnh cá nhân và mục tiêu hướng tới trong công việc...">{{ old('bio', $profile->bio) }}</textarea>
            </div>

            <!-- Upload Files Section -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border">
                    <label class="form-label small fw-bold text-muted"><i class="bi bi-file-earmark-arrow-up text-primary me-1"></i> Tải lên CV đính kèm (PDF, DOC, DOCX - Max 5MB)</label>
                    <input type="file" name="resume_file" class="form-control" accept=".pdf,.doc,.docx">
                    @if($profile->resume_path)
                        <div class="mt-2 small text-success">
                            <i class="bi bi-check-circle-fill"></i> Đang lưu: <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="fw-bold">{{ basename($profile->resume_path) }}</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border">
                    <label class="form-label small fw-bold text-muted"><i class="bi bi-image text-primary me-1"></i> Cập nhật ảnh đại diện (JPG, PNG)</label>
                    <input type="file" name="avatar_file" class="form-control" accept="image/*">
                    <small class="text-muted">Ảnh chân dung rõ mặt giúp hồ sơ trông chuyên nghiệp hơn.</small>
                </div>
            </div>

            <!-- Social Links -->
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted"><i class="bi bi-linkedin text-primary me-1"></i> LinkedIn URL</label>
                <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $profile->linkedin_url) }}" placeholder="https://linkedin.com/in/...">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted"><i class="bi bi-github text-dark me-1"></i> GitHub URL</label>
                <input type="url" name="github_url" class="form-control" value="{{ old('github_url', $profile->github_url) }}" placeholder="https://github.com/...">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted"><i class="bi bi-globe text-info me-1"></i> Portfolio Website</label>
                <input type="url" name="portfolio_url" class="form-control" value="{{ old('portfolio_url', $profile->portfolio_url) }}" placeholder="https://mywebsite.com">
            </div>

            <div class="col-12">
                <div class="form-check form-switch p-3 bg-light rounded-4 border">
                    <input class="form-check-input ms-0 me-3" type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', $profile->is_public) ? 'checked' : '' }} style="transform: scale(1.3);">
                    <label class="form-check-label fw-bold text-dark" for="is_public">
                        Bật chế độ tìm kiếm việc làm (Cho phép Nhà tuyển dụng tìm thấy hồ sơ của bạn)
                    </label>
                    <div class="small text-muted ms-4">Hồ sơ của bạn sẽ hiển thị trong danh bạ Ứng viên tài năng để các công ty chủ động mời phỏng vấn.</div>
                </div>
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold fs-6">
                    <i class="bi bi-check2-circle me-1"></i> Lưu thay đổi hồ sơ
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
