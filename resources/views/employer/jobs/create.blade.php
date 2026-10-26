@extends('layouts.dashboard')

@section('title', 'Đăng Tin Tuyển Dụng Mới - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="border-bottom pb-3 mb-4">
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-pencil-square text-success me-2"></i>Đăng Tin Tuyển Dụng Mới</h4>
        <p class="text-muted small mb-0">Nhập đầy đủ thông tin vị trí công việc để tiếp cận ứng viên chính xác và hiệu quả nhất.</p>
    </div>

    <form action="{{ route('employer.jobs.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Tiêu đề vị trí tuyển dụng <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Ví dụ: Senior Laravel Developer, Chuyên viên Digital Marketing...">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Ngành nghề / Lĩnh vực <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Chọn ngành nghề --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Hình thức làm việc <span class="text-danger">*</span></label>
                <select name="job_type" class="form-select" required>
                    <option value="Full-time" {{ old('job_type') === 'Full-time' ? 'selected' : '' }}>Full-time (Toàn thời gian)</option>
                    <option value="Part-time" {{ old('job_type') === 'Part-time' ? 'selected' : '' }}>Part-time (Bán thời gian)</option>
                    <option value="Remote" {{ old('job_type') === 'Remote' ? 'selected' : '' }}>Remote (Làm việc từ xa)</option>
                    <option value="Internship" {{ old('job_type') === 'Internship' ? 'selected' : '' }}>Internship (Thực tập)</option>
                    <option value="Freelance" {{ old('job_type') === 'Freelance' ? 'selected' : '' }}>Freelance (Tự do)</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Cấp bậc <span class="text-danger">*</span></label>
                <select name="experience_level" class="form-select" required>
                    <option value="Tất cả cấp bậc">Tất cả cấp bậc</option>
                    <option value="Thực tập sinh">Thực tập sinh</option>
                    <option value="Mới tốt nghiệp / Fresher">Mới tốt nghiệp / Fresher</option>
                    <option value="Nhân viên / Junior-Middle" selected>Nhân viên / Junior-Middle</option>
                    <option value="Trưởng nhóm / Senior">Trưởng nhóm / Senior</option>
                    <option value="Quản lý / Trưởng phòng">Quản lý / Trưởng phòng</option>
                </select>
            </div>

            <!-- Salary Range -->
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Lương tối thiểu (Triệu VNĐ)</label>
                <input type="number" name="salary_min" id="salary_min" class="form-control" value="{{ old('salary_min') }}" placeholder="Ví dụ: 15" min="0">
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Lương tối đa (Triệu VNĐ)</label>
                <input type="number" name="salary_max" id="salary_max" class="form-control" value="{{ old('salary_max') }}" placeholder="Ví dụ: 25" min="0">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_negotiable" id="is_negotiable" value="1" {{ old('is_negotiable') ? 'checked' : '' }} onchange="toggleNegotiable(this.checked)">
                    <label class="form-check-label fw-semibold text-dark" for="is_negotiable">
                        Lương thỏa thuận
                    </label>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Khu vực làm việc <span class="text-danger">*</span></label>
                <select name="city" class="form-select" required>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ old('city', $company->city) === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Địa chỉ làm việc cụ thể</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $company->address) }}" placeholder="Tòa nhà, số nhà, đường, quận/huyện...">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Hạn nộp hồ sơ</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Số lượng tuyển</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Kỹ năng yêu cầu (cách nhau bởi dấu phẩy)</label>
                <input type="text" name="skills_required" class="form-control" value="{{ old('skills_required') }}" placeholder="PHP, Laravel, MySQL, Docker, RESTful API...">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Mô tả công việc chi tiết <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="5" required placeholder="• Liệt kê các nhiệm vụ, trách nhiệm chính của vị trí...&#10;• Quy trình làm việc và phối hợp nhóm...">{{ old('description') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Yêu cầu đối với ứng viên</label>
                <textarea name="requirements" class="form-control" rows="5" placeholder="• Trình độ chuyên môn, số năm kinh nghiệm...&#10;• Kỹ năng cứng, kỹ năng mềm, ngoại ngữ...">{{ old('requirements') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Quyền lợi & Chế độ đãi ngộ</label>
                <textarea name="benefits" class="form-control" rows="5" placeholder="• Thu nhập, thưởng tháng 13, thưởng dự án...&#10;• Bảo hiểm sức khỏe, du lịch hàng năm, phụ cấp ăn trưa...">{{ old('benefits') }}</textarea>
            </div>

            <div class="col-12 text-end mt-4">
                <a href="{{ route('employer.jobs.index') }}" class="btn btn-light rounded-pill px-4 me-2">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Xuất bản tin tuyển dụng
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleNegotiable(checked) {
    document.getElementById('salary_min').disabled = checked;
    document.getElementById('salary_max').disabled = checked;
}
</script>
@endsection
