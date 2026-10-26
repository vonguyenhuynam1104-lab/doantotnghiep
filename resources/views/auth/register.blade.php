@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản - JobConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card card-custom p-4 p-md-5 border shadow-sm">
                <div class="text-center mb-4">
                    <span class="brand-badge fs-4 p-2 mb-2 d-inline-block"><i class="bi bi-briefcase-fill"></i></span>
                    <h3 class="fw-bold text-dark">Tạo Tài Khoản Mới</h3>
                    <p class="text-muted small">Bắt đầu hành trình tìm kiếm việc làm hoặc tuyển dụng nhân tài</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <!-- Role Selection -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted d-block text-center mb-2">Bạn muốn tham gia với vai trò nào?</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role" id="role_candidate" value="candidate" {{ old('role', request('role', 'candidate')) === 'candidate' ? 'checked' : '' }} onchange="toggleEmployerFields(false)">
                                <label class="btn btn-outline-primary w-100 py-3 rounded-4 text-center d-flex flex-column align-items-center justify-content-center h-100" for="role_candidate">
                                    <i class="bi bi-person-badge fs-3 mb-1"></i>
                                    <span class="fw-bold">Ứng viên tìm việc</span>
                                    <small class="text-muted" style="font-size: 11px;">Tìm việc & Nộp CV</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role" id="role_employer" value="employer" {{ old('role', request('role')) === 'employer' ? 'checked' : '' }} onchange="toggleEmployerFields(true)">
                                <label class="btn btn-outline-primary w-100 py-3 rounded-4 text-center d-flex flex-column align-items-center justify-content-center h-100" for="role_employer">
                                    <i class="bi bi-building fs-3 mb-1"></i>
                                    <span class="fw-bold">Nhà tuyển dụng</span>
                                    <small class="text-muted" style="font-size: 11px;">Đăng tin & Chiêu mộ</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Nguyễn Văn A">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Địa chỉ Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required placeholder="name@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Số điện thoại liên hệ</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="09xxxxxxx">
                    </div>

                    <!-- Employer Specific Fields -->
                    <div id="employerFields" style="{{ old('role', request('role')) === 'employer' ? '' : 'display: none;' }}">
                        <div class="p-3 bg-light rounded-4 border mb-3">
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-building me-1"></i> Thông Tin Doanh Nghiệp</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tên công ty / Doanh nghiệp <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="form-control" placeholder="Ví dụ: Công ty Cổ phần Công nghệ ABC">
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Trụ sở Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                    <select name="city" class="form-select">
                                        <option value="Hà Nội">Hà Nội</option>
                                        <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                                        <option value="Đà Nẵng">Đà Nẵng</option>
                                        <option value="Hải Phòng">Hải Phòng</option>
                                        <option value="Cần Thơ">Cần Thơ</option>
                                        <option value="Toàn quốc">Toàn quốc</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Quy mô nhân sự</label>
                                    <select name="company_size" class="form-select">
                                        <option value="10-50 nhân viên">10 - 50 nhân viên</option>
                                        <option value="50-150 nhân viên">50 - 150 nhân viên</option>
                                        <option value="150-500 nhân viên">150 - 500 nhân viên</option>
                                        <option value="500-1000 nhân viên">500 - 1000 nhân viên</option>
                                        <option value="1000+ nhân viên">1000+ nhân viên</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required placeholder="Tối thiểu 6 ký tự">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" required id="agree">
                        <label class="form-check-label small text-muted" for="agree">
                            Tôi đồng ý với các <a href="#" class="text-decoration-none text-primary">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none text-primary">Chính sách bảo mật</a> của JobConnect.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold rounded-pill fs-6 mb-3">
                        <i class="bi bi-person-check me-1"></i> Hoàn tất đăng ký
                    </button>

                    <div class="text-center small text-muted">
                        Đã có tài khoản? <a href="{{ route('login') }}" class="fw-bold text-primary text-decoration-none">Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEmployerFields(show) {
    const fields = document.getElementById('employerFields');
    const compName = document.getElementById('company_name');
    if (show) {
        fields.style.display = 'block';
        compName.setAttribute('required', 'required');
    } else {
        fields.style.display = 'none';
        compName.removeAttribute('required');
    }
}
</script>
@endsection
