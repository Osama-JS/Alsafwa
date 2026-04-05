@extends('admin.layouts.master')

@section('title', 'تعديل بيانات الشريك')
@section('page_title', 'الشركاء')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">الشركاء</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل شريك</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تعديل بيانات: {{ $partner->name_ar }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Names -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الشريك (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $partner->name_ar) }}" required>
                                @error('name_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الشريك (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $partner->name_en) }}" required>
                                @error('name_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- URL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">رابط الموقع الإلكتروني (اختياري)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-link text-muted"></i></span>
                                <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $partner->url) }}" placeholder="https://example.com">
                            </div>
                            @error('url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">شعار الشريك (اتركه فارغاً للإبقاء على الشعار الحالي)</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" onchange="previewImage(this, 'partner-preview')">
                            @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-3">
                                <div class="d-flex gap-4 align-items-end">
                                    <div>
                                        <p class="text-xs text-muted mb-2">الشعار الحالي:</p>
                                        <div style="width: 150px; height: 100px; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="Current" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                    <div id="partner-preview-container" class="preview-box d-none" style="width: 150px; height: 100px; border: 2px dashed var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;">
                                        <img id="partner-preview" src="#" alt="New Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $partner->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="inactive" {{ old('status', $partner->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $partner->order) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.partners.index') }}" class="btn btn-light px-4">إلغاء</a>
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
