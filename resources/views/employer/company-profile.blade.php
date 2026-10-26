@extends('layouts.dashboard')

@section('title', 'Thông Tin Thương Hiệu Doanh Nghiệp - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-building text-primary me-2"></i>Hồ Sơ Doanh Nghiệp</h4>
            <p class="text-muted small mb-0">Xây dựng trang thương hiệu chuyên nghiệp để thu hút các ứng viên hàng đầu.</p>
        </div>
        <a href="{{ route('companies.show', $company->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Xem trang công khai
        </a>
    </div>

    <form action="{{ route('employer.company_profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Tên công ty / Doanh nghiệp <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Lĩnh vực hoạt động</label>
                <input type="text" name="industry" class="form-control" value="{{ old('industry', $company->industry) }}" placeholder="Ví dụ: Công nghệ thông tin / Thương mại điện tử">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Quy mô nhân sự</label>
                <select name="company_size" class="form-select">
                    @foreach(['10-50 nhân viên', '50-150 nhân viên', '150-500 nhân viên', '500-1000 nhân viên', '1000+ nhân viên', '5000+ nhân viên', '10,000+ nhân viên'] as $size)
                        <option value="{{ $size }}" {{ old('company_size', $company->company_size) === $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Trụ sở Tỉnh / Thành phố <span class="text-danger">*</span></label>
                <select name="city" class="form-select" required>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ old('city', $company->city) === $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Website chính thức</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $company->website) }}" placeholder="https://example.com">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Email liên hệ tuyển dụng</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}" placeholder="tuyendung@company.com">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Số điện thoại hotline</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}" placeholder="024xxxxxxx">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Địa chỉ văn phòng chi tiết</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $company->address) }}" placeholder="Số nhà, đường, quận/huyện...">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Giới thiệu về công ty & Văn hóa làm việc</label>
                <textarea name="description" class="form-control" rows="5" placeholder="Mô tả quá trình thành lập, sứ mệnh, môi trường làm việc, chế độ đãi ngộ...">{{ old('description', $company->description) }}</textarea>
            </div>

            <!-- Logo & Cover Uploads -->
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border">
                    <label class="form-label small fw-bold text-muted"><i class="bi bi-image text-primary me-1"></i> Logo công ty (Kích thước vuông, JPG/PNG)</label>
                    <input type="file" name="logo_file" class="form-control" accept="image/*">
                    @if($company->logo)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $company->logo_url }}" alt="logo" class="company-logo-img" style="width: 44px; height: 44px;">
                            <small class="text-muted">Logo hiện tại</small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border">
                    <label class="form-label small fw-bold text-muted"><i class="bi bi-card-image text-primary me-1"></i> Ảnh bìa / Cover Banner (JPG/PNG - Max 4MB)</label>
                    <input type="file" name="cover_file" class="form-control" accept="image/*">
                    @if($company->cover_image)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <img src="{{ $company->cover_image }}" alt="cover" class="rounded border" style="width: 80px; height: 44px; object-fit: cover;">
                            <small class="text-muted">Ảnh bìa hiện tại</small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Cập nhật thông tin công ty
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
