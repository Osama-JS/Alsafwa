@extends('admin.layouts.master')

@section('title', 'تعديل بيانات الموزع')
@section('page_title', 'الموزعين')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.distributors.index') }}">الموزعين</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل موزع</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تعديل بيانات: {{ $distributor->name_ar }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.distributors.update', $distributor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الموزع (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $distributor->name_ar) }}" required>
                                @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الموزع (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $distributor->name_en) }}" required>
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي)</label>
                                <input type="text" name="address_ar" class="form-control @error('address_ar') is-invalid @enderror" value="{{ old('address_ar', $distributor->address_ar) }}">
                                @error('address_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي)</label>
                                <input type="text" name="address_en" class="form-control @error('address_en') is-invalid @enderror" value="{{ old('address_en', $distributor->address_en) }}">
                                @error('address_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تفاصيل (عربي)</label>
                                <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror" rows="3">{{ old('description_ar', $distributor->description_ar) }}</textarea>
                                @error('description_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تفاصيل (إنجليزي)</label>
                                <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="3">{{ old('description_en', $distributor->description_en) }}</textarea>
                                @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Phone & Map -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رقم الهاتف (اختياري)</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $distributor->phone) }}" placeholder="مثال: 0500000000">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رابط خريطة جوجل (Iframe URL)</label>
                                <input type="text" name="map_url" class="form-control @error('map_url') is-invalid @enderror" value="{{ old('map_url', $distributor->map_url) }}">
                                @error('map_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- URL & Products -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رابط الموقع الإلكتروني</label>
                                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $distributor->url) }}" placeholder="https://example.com">
                                @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المنتجات المرتبطة</label>
                                <select name="products[]" class="form-select select2 @error('products') is-invalid @enderror" multiple>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ in_array($product->id, old('products', $distributorProducts)) ? 'selected' : '' }}>
                                            {{ $product->title_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('products') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">شعار الموزع (اتركه فارغاً لعدم التغيير)</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" onchange="previewImage(this, 'distributor-preview')">
                            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-3">
                                <div class="d-flex gap-4 align-items-end">
                                    <div>
                                        <p class="text-xs text-muted mb-2">الشعار الحالي:</p>
                                        <div style="width: 150px; height: 150px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                            <img src="{{ asset('storage/' . $distributor->logo) }}" alt="Current" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div id="distributor-preview-container" class="preview-box d-none" style="width: 150px; height: 150px; border: 2px dashed var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                        <img id="distributor-preview" src="#" alt="New Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $distributor->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $distributor->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $distributor->order) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.distributors.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث البيانات
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
    .select2-container--bootstrap-4 .select2-selection { border-radius: 0.5rem; height: calc(2.25rem + 2px); }
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
