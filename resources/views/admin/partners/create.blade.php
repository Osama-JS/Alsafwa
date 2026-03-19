@extends('admin.layouts.master')

@section('title', 'إضافة شريك جديد')
@section('page_title', 'الشركاء')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">الشركاء</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الشريك الجديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الشريك (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" value="{{ old('name_ar') }}" placeholder="مثال: شركة الصفوة" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الشريك (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="Example: Al-Safwa Co." required>
                            </div>
                        </div>

                        <!-- URL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">رابط الموقع الإلكتروني (اختياري)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-link text-muted"></i></span>
                                <input type="url" name="url" class="form-control" value="{{ old('url') }}" placeholder="https://example.com">
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">شعار الشريك <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control" onchange="previewImage(this, 'partner-preview')" required>
                            <div class="mt-3">
                                <div id="partner-preview-container" class="preview-box d-none" style="width: 150px; height: 100px; border: 2px dashed #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                    <img id="partner-preview" src="#" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
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
                            <a href="{{ route('admin.partners.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الشريك
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
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
