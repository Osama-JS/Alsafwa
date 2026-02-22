@extends('admin.layouts.master')

@section('title', 'تعديل الخدمة')
@section('page_title', 'الخدمات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">الخدمات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل: {{ $service->title_ar }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات الخدمة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Titles -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar', $service->title_ar) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي)</label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $service->title_en) }}">
                            </div>
                        </div>

                        <!-- Descriptions (Short) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف مختصر (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar', $service->description_ar) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف مختصر (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $service->description_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Content (Full) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المحتوى الكامل (عربي)</label>
                                <textarea name="content_ar" class="form-control" rows="5">{{ old('content_ar', $service->content_ar) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المحتوى الكامل (إنجليزي)</label>
                                <textarea name="content_en" class="form-control" rows="5">{{ old('content_en', $service->content_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Image & Icon -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">أيقونة (FontAwesome Class)</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">صورة الخدمة</label>
                                <input type="file" name="image" class="form-control" onchange="previewImage(this, 'service-preview')">
                                <div class="mt-2">
                                    @if($service->image)
                                        <img id="service-preview" src="{{ asset('storage/' . $service->image) }}" alt="Preview" style="max-width: 150px; border-radius: 8px;">
                                    @else
                                        <img id="service-preview" src="#" alt="Preview" style="display: none; max-width: 150px; border-radius: 8px;">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ $service->status == 'published' ? 'selected' : '' }}>منشور</option>
                                    <option value="draft" {{ $service->status == 'draft' ? 'selected' : '' }}>مسودة</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $service->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث الخدمة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
