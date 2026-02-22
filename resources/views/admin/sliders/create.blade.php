@extends('admin.layouts.master')

@section('title', 'إضافة شريحة جديدة')
@section('page_title', 'السلايدر')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">السلايدر</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الشريحة الجديدة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Titles -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الرئيسي</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="العنوان الظاهر على الشريحة">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الفرعي</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="نص توضيحي إضافي">
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة الشريحة <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'slider-preview')" required>
                            <div class="mt-2 text-muted text-xs">يفضل أن تكون الصورة بدقة عالية وعرض لا يقل عن 1920px.</div>
                            <div class="mt-2">
                                <img id="slider-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Buttons & Links -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الرابط (اختياري)</label>
                                <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://example.com/page">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (عربي)</label>
                                <input type="text" name="button_text_ar" class="form-control" value="{{ old('button_text_ar') }}" placeholder="مثال: اقرأ المزيد">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (إنجليزي)</label>
                                <input type="text" name="button_text_en" class="form-control" value="{{ old('button_text_en') }}" placeholder="Ex: Read More">
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
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الشريحة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
