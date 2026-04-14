@extends('admin.layouts.master')

@section('title', 'إضافة قسم جديد')
@section('page_title', 'أقسام معرض الصور')
@section('breadcrumb')
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.gallery.index') }}">المعرض</a></li>
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.gallery-categories.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius:20px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> إضافة قسم جديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.gallery-categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">الاسم (بالعربية) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}" required>
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">الاسم (بالإنجليزية) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en') }}" required>
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">الحالة <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5 py-2.5 rounded-pill fw-bold">
                                <i class="fas fa-save me-2"></i> حفظ القسم
                            </button>
                            <a href="{{ route('admin.gallery-categories.index') }}" class="btn btn-light px-4 py-2.5 rounded-pill fw-bold">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
