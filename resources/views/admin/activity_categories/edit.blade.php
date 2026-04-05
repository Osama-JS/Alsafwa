@extends('admin.layouts.master')

@section('title', 'تعديل التصنيف')
@section('page_title', 'تصنيفات الأنشطة')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.activity-categories.index') }}">تصنيفات الأنشطة</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل التصنيف</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تعديل التصنيف: {{ $activityCategory->name_ar }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.activity-categories.update', $activityCategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم التصنيف (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $activityCategory->name_ar) }}" required>
                                @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم التصنيف (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $activityCategory->name_en) }}" required>
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $activityCategory->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $activityCategory->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $activityCategory->order) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Slug (Read Only Display) -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold small">الرابط الدائم (Slug)</label>
                                <input type="text" class="form-control bg-light" value="{{ $activityCategory->slug }}" readonly>
                                <div class="form-text small opacity-75">سيتم تحديث الرابط تلقائياً عند تغيير الاسم الإنجليزي.</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
