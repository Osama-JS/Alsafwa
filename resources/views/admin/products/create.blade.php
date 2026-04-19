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
                                <textarea name="description_ar" class="form-control editor-rich @error('description_ar') is-invalid @enderror" rows="4">{{ old('description_ar') }}</textarea>
                                @error('description_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control editor-rich @error('description_en') is-invalid @enderror" rows="4">{{ old('description_en') }}</textarea>
                                @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الصورة الرئيسية <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this, 'product-preview')" required>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="product-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 150px; border-radius: 8px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">صور إضافية (المعرض)</label>
                                <input type="file" name="gallery[]" class="form-control @error('gallery.*') is-invalid @enderror" multiple>
                                @error('gallery.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2 text-muted text-xs">يمكنك اختيار عدة صور معاً.</div>
                            </div>
                        </div>

                        <!-- Price & Discount -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">السعر (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">الخصم (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('discount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            @php
                                $oldCatId = old('product_category_id');
                                $oldParentId = null;
                                if ($oldCatId) {
                                    $oldCat = \App\Models\ProductCategory::find($oldCatId);
                                    $oldParentId = $oldCat ? ($oldCat->parent_id ?: $oldCat->id) : null;
                                }
                            @endphp

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">القسم الرئيسي <span class="text-danger">*</span></label>
                                <select id="main_category" name="main_category_id" class="form-select @error('main_category_id') is-invalid @enderror" onchange="updateSubCategories()">
                                    <option value="">اختر القسم الرئيسي</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-children='@json($category->children)' {{ $oldParentId == $category->id ? 'selected' : '' }}>{{ $category->name_ar }}</option>
                                    @endforeach
                                </select>
                                @error('main_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3" id="sub_category_container" style="{{ $oldParentId && $categories->find($oldParentId)->children->count() > 0 ? '' : 'display: none;' }}">
                                <label class="form-label fw-bold small">القسم الفرعي <span class="text-danger">*</span></label>
                                <select id="sub_category" name="product_category_id" class="form-select @error('product_category_id') is-invalid @enderror">
                                    <option value="">اختر القسم الفرعي</option>
                                    @if($oldParentId && $categories->find($oldParentId))
                                        @foreach($categories->find($oldParentId)->children as $child)
                                            <option value="{{ $child->id }}" {{ $oldCatId == $child->id ? 'selected' : '' }}>{{ $child->name_ar }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('product_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">الوكالة (اختياري)</label>
                                <select name="agency_id" class="form-select @error('agency_id') is-invalid @enderror">
                                    <option value="">بدون وكالة</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>{{ $agency->name_ar }}</option>
                                    @endforeach
                                </select>
                                @error('agency_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateSubCategories() {
        const mainSelect = document.getElementById('main_category');
        const subSelect = document.getElementById('sub_category');
        const container = document.getElementById('sub_category_container');
        
        const selectedOption = mainSelect.options[mainSelect.selectedIndex];
        if (!selectedOption || mainSelect.value === "") {
            container.style.display = 'none';
            subSelect.required = false;
            subSelect.value = "";
            return;
        }

        const childrenJson = selectedOption.getAttribute('data-children');
        
        // Reset sub categories
        subSelect.innerHTML = '<option value="">اختر القسم الفرعي</option>';
        
        if (childrenJson) {
            const children = JSON.parse(childrenJson);
            
            if (children.length > 0) {
                children.forEach(child => {
                    const opt = document.createElement('option');
                    opt.value = child.id;
                    opt.textContent = child.name_ar;
                    subSelect.appendChild(opt);
                });
                
                container.style.display = 'block';
                subSelect.required = true;
            } else {
                container.style.display = 'none';
                subSelect.required = false;
                subSelect.value = "";
            }
        } else {
            container.style.display = 'none';
            subSelect.required = false;
            subSelect.value = "";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const subSelect = document.getElementById('sub_category');
        const container = document.getElementById('sub_category_container');
        if (container && container.style.display !== 'none') {
            subSelect.required = true;
        }
    });
</script>
@endpush
@endsection
