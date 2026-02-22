@extends('admin.layouts.master')

@section('title', 'إضافة منتج جديد')
@section('page_title', 'المنتجات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات المنتج الجديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Titles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">عنوان المنتج (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}" required>
                                @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">عنوان المنتج (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                                @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Descriptions AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en') }}</textarea>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة المنتج <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this, 'product-preview')" required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-2">
                                <img id="product-preview" src="#" alt="Preview" style="display: none; max-width: 300px; height: auto; max-height: 200px; border-radius: 8px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Price & Discount -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">السعر (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الخصم (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="discount" class="form-control" value="{{ old('discount') }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الوكالة (اختياري)</label>
                                <select name="agency_id" class="form-select">
                                    <option value="">بدون وكالة</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>{{ $agency->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="active" selected>نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
