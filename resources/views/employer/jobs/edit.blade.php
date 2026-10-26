@extends('layouts.dashboard')

@section('title', 'Chỉnh Sửa Tin Tuyển Dụng - JobConnect')

@section('dashboard_content')
<div class="card card-custom p-4 border shadow-sm mb-4">
    <div class="border-bottom pb-3 mb-4">
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-pencil-square text-primary me-2"></i>Chỉnh Sửa Tin Tuyển Dụng</h4>
        <p class="text-muted small mb-0">{{ $job->title }}</p>
    </div>

    <form action="{{ route('employer.jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-9">
                <label class="form-label small fw-bold text-muted">Tiêu đề vị trí tuyển dụng <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Trạng thái tin <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ old('status', $job->status) === 'published' ? 'selected' : '' }}>Hiển thị công khai</option>
                    <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Đóng nhận hồ sơ</option>
                    <option value="draft" {{ old('status', $job->status) === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Ngành nghề / Lĩnh vực <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Hình thức làm việc <span class="text-danger">*</span></label>
                <select name="job_type" class="form-select" required>
                    @foreach(['Full-time', 'Part-time', 'Remote', 'Internship', 'Freelance'] as $t)
                        <option value="{{ $t }}" {{ old('job_type', $job->job_type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Cấp bậc <span class="text-danger">*</span></label>
                <select name="experience_level" class="form-select" required>
                    @foreach(['Tất cả cấp bậc', 'Thực tập sinh', 'Mới tốt nghiệp / Fresher', 'Nhân viên / Junior-Middle', 'Trưởng nhóm / Senior', 'Quản lý / Trưởng phòng'] as $lvl)
                        <option value="{{ $lvl }}" {{ old('experience_level', $job->experience_level) === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Salary Range -->
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Lương tối thiểu (Triệu VNĐ)</label>
                <input type="number" name="salary_min" id="salary_min" class="form-control" value="{{ old('salary_min', $job->salary_min ? $job->salary_min / 1000000 : '') }}" {{ $job->is_negotiable ? 'disabled' : '' }}>
            </div>

            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted">Lương tối đa (Triệu VNĐ)</label>
                <input type="number" name="salary_max" id="salary_max" class="form-control" value="{{ old('salary_max', $job->salary_max ? $job->salary_max / 1000000 : '') }}" {{ $job->is_negotiable ? 'disabled' : '' }}>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_negotiable" id="is_negotiable" value="1" {{ old('is_negotiable', $job->is_negotiable) ? 'checked' : '' }} onchange="toggleNegotiable(this.checked)">
                    <label class="form-check-label fw-semibold text-dark" for="is_negotiable">
                        Lương thỏa thuận
                    </label>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Khu vực làm việc <span class="text-danger">*</span></label>
                <select name="city" class="form-select" required>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ old('city', $job->city) === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Địa chỉ làm việc cụ thể</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $job->address) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Hạn nộp hồ sơ</label>
                <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline ? $job->deadline->format('Y-m-d') : '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Số lượng tuyển</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $job->quantity) }}" min="1">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Kỹ năng yêu cầu (cách nhau bởi dấu phẩy)</label>
                <input type="text" name="skills_required" class="form-control" value="{{ old('skills_required', $job->skills_required) }}">
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Mô tả công việc chi tiết <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Yêu cầu đối với ứng viên</label>
                <textarea name="requirements" class="form-control" rows="5">{{ old('requirements', $job->requirements) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label small fw-bold text-muted">Quyền lợi & Chế độ đãi ngộ</label>
                <textarea name="benefits" class="form-control" rows="5">{{ old('benefits', $job->benefits) }}</textarea>
            </div>

            <div class="col-12 text-end mt-4">
                <a href="{{ route('employer.jobs.index') }}" class="btn btn-light rounded-pill px-4 me-2">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary-gradient px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Lưu thay đổi
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
