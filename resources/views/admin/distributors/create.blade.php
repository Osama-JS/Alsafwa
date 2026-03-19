@extends('admin.layouts.master')

@section('title', 'إضافة موزع جديد')
@section('page_title', 'الموزعين')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.distributors.index') }}">الموزعين</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الموزع الجديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.distributors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الموزع (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" placeholder="مثال: شركة الصفا للتوزيع" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الموزع (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="Example: Al-Safa Distribution" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي)</label>
                                <input type="text" name="address_ar" class="form-control" value="{{ old('address_ar') }}" placeholder="مثال: الرياض، حي الملز">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي)</label>
                                <input type="text" name="address_en" class="form-control" value="{{ old('address_en') }}" placeholder="Example: Riyadh, Al-Malaz">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تفاصيل (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="3">{{ old('description_ar') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تفاصيل (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
                            </div>
                        </div>

                        <!-- Phone & Map -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رقم الهاتف (اختياري)</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="مثال: 0500000000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رابط خريطة جوجل (Iframe URL)</label>
                                <input type="text" name="map_url" class="form-control" value="{{ old('map_url') }}" placeholder="مثال: https://www.google.com/maps/embed?pb=...">
                            </div>
                        </div>

                        <!-- URL & Products -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رابط الموقع الإلكتروني</label>
                                <input type="url" name="url" class="form-control" value="{{ old('url') }}" placeholder="https://example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المنتجات المرتبطة</label>
                                <select name="products[]" class="form-select select2" multiple>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                                            {{ $product->title_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">شعار الموزع <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control" onchange="previewImage(this, 'distributor-preview')" required>
                            <div class="mt-3">
                                <div id="distributor-preview-container" class="preview-box d-none" style="width: 150px; height: 150px; border: 2px dashed #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                    <img id="distributor-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
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
                            <a href="{{ route('admin.distributors.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الموزع
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection { border-radius: 0.5rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-4',
            placeholder: "اختر المنتجات...",
            dir: "rtl"
        });
    });

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const container = document.getElementById(previewId + '-container');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
