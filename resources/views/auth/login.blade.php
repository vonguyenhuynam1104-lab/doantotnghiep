@extends('layouts.app')

@section('title', 'Đăng Nhập Tài Khoản - JobConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="card card-custom p-4 p-md-5 border shadow-sm">
                <div class="text-center mb-4">
                    <span class="brand-badge fs-4 p-2 mb-2 d-inline-block"><i class="bi bi-briefcase-fill"></i></span>
                    <h3 class="fw-bold text-dark">Chào Mừng Trở Lại</h3>
                    <p class="text-muted small">Đăng nhập để kết nối với hàng ngàn cơ hội việc làm</p>
                </div>

                <!-- Test accounts quick-fill bar -->
                <div class="alert alert-light border rounded-4 mb-4 p-3">
                    <div class="small fw-bold text-muted mb-2"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> Tài khoản mẫu dùng để thử nghiệm:</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-2" onclick="fillLogin('ungvien@jobconnect.vn', 'password')">
                            <i class="bi bi-person"></i> Ứng viên mẫu
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill py-1 px-2" onclick="fillLogin('fpt@jobconnect.vn', 'password')">
                            <i class="bi bi-building"></i> Tuyển dụng FPT
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill py-1 px-2" onclick="fillLogin('admin@jobconnect.vn', 'password')">
                            <i class="bi bi-shield-lock"></i> Quản trị viên
                        </button>
                    </div>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Địa chỉ Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required placeholder="name@example.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-muted mb-0">Mật khẩu</label>
                            <a href="#" class="small text-primary text-decoration-none">Quên mật khẩu?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary-gradient w-100 py-2 fw-bold rounded-pill fs-6 mb-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                    </button>

                    <div class="text-center small text-muted">
                        Chưa có tài khoản? <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function fillLogin(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
