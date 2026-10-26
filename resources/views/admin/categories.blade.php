@extends('layouts.dashboard')

@section('title', 'Quản Lý Danh Mục Ngành Nghề - JobConnect Admin')

@section('dashboard_content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-custom p-4 border shadow-sm">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-tags-fill text-primary me-2"></i>Danh Sách Ngành Nghề</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Icon</th>
                            <th>Tên danh mục</th>
                            <th>Số tin tuyển</th>
                            <th>Nổi bật</th>
                            <th class="text-end">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="rounded-3 bg-light text-primary p-2 d-inline-flex">
                                        <i class="bi {{ $category->icon ?: 'bi-briefcase' }} fs-5"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $category->name }}</div>
                                    <small class="text-muted">{{ $category->slug }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                                        {{ $category->jobs_count }} việc làm
                                    </span>
                                </td>
                                <td>
                                    @if($category->is_featured)
                                        <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Có</span>
                                    @else
                                        <span class="badge bg-light text-muted border">Không</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Xóa danh mục">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-custom p-4 border shadow-sm">
            <h5 class="fw-bold text-dark border-bottom pb-3 mb-3"><i class="bi bi-plus-circle-fill text-success me-2"></i>Thêm Ngành Nghề Mới</h5>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Logistics & Chuỗi cung ứng">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Bootstrap Icon class</label>
                    <input type="text" name="icon" class="form-control" value="bi-briefcase" placeholder="bi-laptop, bi-truck, bi-cash-coin...">
                    <small class="text-muted">Chọn icon từ Bootstrap Icons (vd: bi-laptop, bi-palette, bi-graph-up-arrow)</small>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Mô tả ngắn</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả các vị trí nghề nghiệp thuộc danh mục này..."></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" checked>
                    <label class="form-check-label small fw-semibold text-dark" for="is_featured">
                        Hiển thị tại khu vực Ngành nghề nổi bật ở Trang chủ
                    </label>
                </div>

                <button type="submit" class="btn btn-primary-gradient w-100 rounded-pill py-2 fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Lưu danh mục mới
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
