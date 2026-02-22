@extends('admin.layouts.master')

@section('title', 'إضافة عداد جديد')
@section('page_title', 'إضافة عداد')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.counters.index') }}" class="text-decoration-none text-muted">إحصائيات الشركة</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة عداد جديد</li>
@endsection

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold"><i class="fas fa-plus-circle text-primary me-2"></i> بيانات العداد الجديد</h6>
            <a href="{{ route('admin.counters.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-right me-1"></i> عودة للقائمة</a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.counters.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان (بالعربية)</label>
                        <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}" required placeholder="مثال: فرع معتمد">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان (بالإنجليزية)</label>
                        <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required placeholder="Ex: Certified Branches">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">القيمة</label>
                        <input type="number" name="value" class="form-control" value="{{ old('value', 0) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">الأيقونة (FontAwesome)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-icons"></i></span>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', 'fas fa-star') }}" required placeholder="مثال: fas fa-rocket">
                        </div>
                        <small class="text-muted">نظام Font Awesome 6 متاح.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">الترتيب</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط (يظهر في الموقع)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);">
                        <i class="fas fa-save me-2"></i> حفظ العداد
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
