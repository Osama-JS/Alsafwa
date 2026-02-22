@extends('admin.layouts.master')

@section('title', 'تعديل المنتج')
@section('page_title', 'المنتجات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل المنتج</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات المنتج</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Titles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">عنوان المنتج (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $product->title_ar) }}" required>
                                @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">عنوان المنتج (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $product->title_en) }}" required>
                                @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Descriptions AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar', $product->description_ar) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en', $product->description_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة المنتج</label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'product-preview')">
                            <div class="mt-2 text-muted text-xs">اتركها فارغة إذا لم ترد التغيير.</div>
                            <div class="mt-2">
                                @if($product->image)
                                    <img id="product-preview" src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="max-width: 300px; height: auto; max-height: 200px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <img id="product-preview" src="#" alt="Preview" style="display: none; max-width: 300px; height: auto; max-height: 200px; border-radius: 8px; object-fit: cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Price & Discount -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">السعر (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $product->price) }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الخصم (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="discount" class="form-control" value="{{ old('discount', $product->discount) }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الوكالة (اختياري)</label>
                                <select name="agency_id" class="form-select">
                                    <option value="">بدون وكالة</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}" {{ old('agency_id', $product->agency_id) == $agency->id ? 'selected' : '' }}>{{ $agency->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $product->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
