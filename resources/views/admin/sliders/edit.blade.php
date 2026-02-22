@extends('admin.layouts.master')

@section('title', 'تعديل الشريحة')
@section('page_title', 'السلايدر')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">السلايدر</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل الشريحة</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات الشريحة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Titles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الرئيسي (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar', $slider->title_ar) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الرئيسي (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $slider->title_en) }}" required>
                            </div>
                        </div>

                        <!-- Subtitles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الفرعي (عربي)</label>
                                <input type="text" name="subtitle_ar" class="form-control" value="{{ old('subtitle_ar', $slider->subtitle_ar) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الفرعي (إنجليزي)</label>
                                <input type="text" name="subtitle_en" class="form-control" value="{{ old('subtitle_en', $slider->subtitle_en) }}">
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة الشريحة</label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'slider-preview')">
                            <div class="mt-2 text-muted text-xs">اتركها فارغة إذا لم ترد التغيير.</div>
                            <div class="mt-2">
                                @if($slider->image)
                                    <img id="slider-preview" src="{{ asset('storage/' . $slider->image) }}" alt="Preview" style="max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <img id="slider-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; object-fit: cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Buttons & Links -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الرابط (اختياري)</label>
                                <input type="url" name="link" class="form-control" value="{{ old('link', $slider->link) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (عربي)</label>
                                <input type="text" name="button_text_ar" class="form-control" value="{{ old('button_text_ar', $slider->button_text_ar) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (إنجليزي)</label>
                                <input type="text" name="button_text_en" class="form-control" value="{{ old('button_text_en', $slider->button_text_en) }}">
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ $slider->status == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ $slider->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $slider->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث الشريحة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
