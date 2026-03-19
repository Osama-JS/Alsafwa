@extends('admin.layouts.master')

@section('title', 'تعديل الوكالة')
@section('page_title', 'الوكالات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.agencies.index') }}">الوكالات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل: {{ $agency->name_ar }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات الوكالة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.agencies.update', $agency->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الاسم (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar', $agency->name_ar) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الاسم (إنجليزي)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $agency->name_en) }}">
                            </div>
                        </div>

                        <!-- Logo & Website -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الشعار (Logo)</label>
                                <input type="file" name="logo" class="form-control" onchange="previewImage(this, 'logo-preview')">
                                <div class="mt-2">
                                    @if($agency->logo)
                                        <img id="logo-preview" src="{{ asset('storage/' . $agency->logo) }}" alt="Logo" style="max-width:150px; border-radius:8px;">
                                    @else
                                        <img id="logo-preview" src="#" alt="Preview" style="display:none; max-width:150px; border-radius:8px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الموقع الإلكتروني</label>
                                <input type="url" name="website" class="form-control" value="{{ old('website', $agency->website) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $agency->phone) }}" placeholder="+967 ...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $agency->email) }}" placeholder="agency@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">رابط الخريطة (Google Maps URL)</label>
                                <input type="text" name="map_url" class="form-control" value="{{ old('map_url', $agency->map_url) }}" placeholder="https://goo.gl/maps/...">
                                <div class="form-text small text-muted">أدخل رابط الموقع من خرائط جوجل لعرضه في صفحة الوكيل.</div>
                            </div>
                        </div>

                        <!-- Descriptions -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (عربي)</label>
                                <textarea name="description_ar" class="form-control editor-rich" rows="4">{{ old('description_ar', $agency->description_ar) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control editor-rich" rows="4">{{ old('description_en', $agency->description_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ $agency->status == 'published' ? 'selected' : '' }}>منشور</option>
                                    <option value="draft" {{ $agency->status == 'draft' ? 'selected' : '' }}>مسودة</option>
                                    <option value="archived" {{ $agency->status == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $agency->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.agencies.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث الوكالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
