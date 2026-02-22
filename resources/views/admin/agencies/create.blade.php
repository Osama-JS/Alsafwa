@extends('admin.layouts.master')

@section('title', 'إضافة وكالة جديدة')
@section('page_title', 'الوكالات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.agencies.index') }}">الوكالات</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الوكالة الجديدة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.agencies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الاسم (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الاسم (إنجليزي)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}">
                            </div>
                        </div>

                        <!-- Logo & Website -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الشعار (Logo) <span class="text-danger">*</span></label>
                                <input type="file" name="logo" class="form-control" onchange="previewImage(this, 'logo-preview')" required>
                                <div class="mt-2">
                                    <img id="logo-preview" src="#" alt="Preview" style="display:none; max-width:150px; border-radius:8px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الموقع الإلكتروني</label>
                                <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://example.com">
                            </div>
                        </div>

                        <!-- Descriptions -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en') }}</textarea>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" selected>منشور</option>
                                    <option value="draft">مسودة</option>
                                    <option value="archived">مؤرشف</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.agencies.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الوكالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
