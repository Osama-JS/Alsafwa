@extends('admin.layouts.master')

@section('title', 'تعديل العداد')
@section('page_title', 'تعديل الإحصائية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.counters.index') }}" class="text-decoration-none text-muted">إحصائيات الشركة</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل العداد</li>
@endsection

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold"><i class="fas fa-edit text-primary me-2"></i> تعديل بيانات العداد: {{ $counter->title_ar }}</h6>
            <a href="{{ route('admin.counters.index') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-right me-1"></i> عودة للقائمة</a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.counters.update', $counter->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان (بالعربية)</label>
                        <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar', $counter->title_ar) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان (بالإنجليزية)</label>
                        <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $counter->title_en) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">القيمة</label>
                        <input type="number" name="value" class="form-control" value="{{ old('value', $counter->value) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">الأيقونة (FontAwesome)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="{{ $counter->icon }}"></i></span>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $counter->icon) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">الترتيب</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $counter->order) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $counter->status) == 'active' ? 'selected' : '' }}>نشط (يظهر في الموقع)</option>
                            <option value="inactive" {{ old('status', $counter->status) == 'inactive' ? 'selected' : '' }}>معطل</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);">
                        <i class="fas fa-save me-2"></i> تحديث العداد
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
