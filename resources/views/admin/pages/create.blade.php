@extends('admin.layouts.master')

@section('title', 'إضافة صفحة جديدة')
@section('page_title', 'الصفحات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">الصفحات</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الصفحة الجديدة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Titles -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المحتوى (عربي) <span class="text-danger">*</span></label>
                                <textarea name="content_ar" class="form-control" rows="8" required>{{ old('content_ar') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المحتوى (إنجليزي) <span class="text-danger">*</span></label>
                                <textarea name="content_en" class="form-control" rows="8" required>{{ old('content_en') }}</textarea>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة الصفحة</label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'page-preview')">
                            <div class="mt-2">
                                <img id="page-preview" src="#" alt="Preview" style="display: none; max-width: 200px; border-radius: 8px;">
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" selected>منشور</option>
                                    <option value="draft">مسودة</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الصفحة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
