@extends('admin.layouts.master')

@section('title', 'تعديل الصورة')
@section('page_title', 'معرض الصور')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">معرض الصور</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل الصورة</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات الصورة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.gallery.update', $image->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">العنوان (اختياري)</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $image->title) }}">
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">الصورة</label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(this, 'gallery-preview')" accept="image/*">
                            <div class="mt-2 text-muted text-xs">اتركها فارغة إذا لم ترد التغيير.</div>
                            <div class="mt-3 text-center">
                                @if($image->image)
                                    <img id="gallery-preview" src="{{ asset('storage/' . $image->image) }}" alt="Preview" style="max-width:100%; max-height:300px; border-radius:10px; object-fit:contain; border:2px dashed #dee2e6; padding:5px;">
                                @else
                                    <img id="gallery-preview" src="#" alt="Preview" style="display:none; max-width:100%; max-height:300px; border-radius:10px; object-fit:contain; border:2px dashed #dee2e6; padding:5px;">
                                @endif
                            </div>
                        </div>

                        <!-- Category -->
                        @if(isset($categories) && count($categories) > 0)
                        <div class="mb-3">
                            <label class="form-label fw-bold small">القسم</label>
                            <select name="gallery_category_id" class="form-select">
                                <option value="">اختر القسم</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $image->gallery_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ $image->status == 'published' ? 'selected' : '' }}>منشور</option>
                                    <option value="draft" {{ $image->status == 'draft' ? 'selected' : '' }}>مسودة</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $image->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث الصورة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
