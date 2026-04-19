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
                                <textarea name="description_ar" class="form-control editor-rich @error('description_ar') is-invalid @enderror" rows="4">{{ old('description_ar', $product->description_ar) }}</textarea>
                                @error('description_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الوصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control editor-rich @error('description_en') is-invalid @enderror" rows="4">{{ old('description_en', $product->description_en) }}</textarea>
                                @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Image Section -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الصورة الرئيسية</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this, 'product-preview')">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2 text-muted text-xs">اتركها فارغة إذا لم ترد التغيير.</div>
                                <div class="mt-2">
                                    @if($product->image)
                                        <img id="product-preview" src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="max-width: 100%; height: auto; max-height: 150px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <img id="product-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 150px; border-radius: 8px; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">إضافة صور للمعرض</label>
                                <input type="file" name="gallery[]" class="form-control @error('gallery.*') is-invalid @enderror" multiple>
                                @error('gallery.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2 text-muted text-xs">يمكنك اختيار عدة صور جديدة لإضافتها للمعرض.</div>
                            </div>
                        </div>

                        <!-- Existing Gallery Management -->
                        @if($product->gallery && count($product->gallery) > 0)
                            <div class="mb-4">
                                <label class="form-label fw-bold small mb-3">إدارة صور المعرض الحالية (حدد للحذف)</label>
                                <div class="row g-2">
                                    @foreach($product->gallery as $galImg)
                                        <div class="col-6 col-md-3 col-lg-2">
                                            <div class="position-relative gallery-manage-item">
                                                <img src="{{ asset('storage/' . $galImg) }}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 p-1">
                                                    <input type="checkbox" name="remove_gallery_images[]" value="{{ $galImg }}" class="form-check-input bg-danger border-danger">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Price & Discount -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">السعر (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold small">الخصم (اختياري)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', $product->discount) }}" placeholder="0.00">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('discount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            @php
                                $currentCatId = old('product_category_id', $product->product_category_id);
                                $selectedCategory = \App\Models\ProductCategory::find($currentCatId);
                                $parentCategoryId = $selectedCategory ? ($selectedCategory->parent_id ?: $selectedCategory->id) : null;
                                $subCategoryId = ($selectedCategory && $selectedCategory->parent_id) ? $selectedCategory->id : null;
                                
                                $mainCategory = $parentCategoryId ? $categories->find($parentCategoryId) : null;
                                $hasChildren = $mainCategory && $mainCategory->children->count() > 0;
                            @endphp

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">القسم الرئيسي <span class="text-danger">*</span></label>
                                <select id="main_category" name="main_category_id" class="form-select @error('main_category_id') is-invalid @enderror" onchange="updateSubCategories()">
                                    <option value="">اختر القسم الرئيسي</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            data-children='@json($category->children)'
                                            {{ $parentCategoryId == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('main_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3" id="sub_category_container" style="{{ $hasChildren ? '' : 'display: none;' }}">
                                <label class="form-label fw-bold small">القسم الفرعي <span class="text-danger">*</span></label>
                                <select id="sub_category" name="product_category_id" class="form-select @error('product_category_id') is-invalid @enderror">
                                    <option value="">اختر القسم الفرعي</option>
                                    @if($hasChildren)
                                        @foreach($mainCategory->children as $child)
                                            <option value="{{ $child->id }}" {{ $subCategoryId == $child->id ? 'selected' : '' }}>{{ $child->name_ar }}</option>
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
                                        <option value="{{ $agency->id }}" {{ old('agency_id', $product->agency_id) == $agency->id ? 'selected' : '' }}>{{ $agency->name_ar }}</option>
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
                                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $product->order) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
