@extends('admin.layouts.master')

@section('title', 'إضافة شريحة جديدة')
@section('page_title', 'السلايدر')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">السلايدر</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات الشريحة الجديدة</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">يرجى تصحيح الأخطاء التالية:</h6>
                                        <ul class="mb-0 px-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Titles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الرئيسي (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}" placeholder="مثال: أهلاً بكم في الصفوة">
                                @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الرئيسي (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" placeholder="Ex: Welcome to Alsafwa">
                                @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Subtitles AR/EN -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الفرعي (عربي)</label>
                                <input type="text" name="subtitle_ar" class="form-control @error('subtitle_ar') is-invalid @enderror" value="{{ old('subtitle_ar') }}" placeholder="نص توضيحي إضافي">
                                @error('subtitle_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان الفرعي (إنجليزي)</label>
                                <input type="text" name="subtitle_en" class="form-control @error('subtitle_en') is-invalid @enderror" value="{{ old('subtitle_en') }}" placeholder="Additional description">
                                @error('subtitle_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">صورة الشريحة <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" onchange="previewImage(this, 'slider-preview')">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-2 text-muted text-xs">يفضل أن تكون الصورة بدقة عالية وعرض لا يقل عن 1920px.</div>
                            <div class="mt-2 text-center bg-light rounded-3 p-2" style="min-height: 100px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                <img id="slider-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; object-fit: cover;">
                                <div id="preview-placeholder" class="text-muted small"><i class="fas fa-image fa-3x mb-2 d-block"></i> سيظهر هنا معاينة الصورة</div>
                            </div>
                        </div>

                        <!-- Buttons & Links -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">الرابط (اختياري)</label>
                                <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com/page">
                                @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (عربي)</label>
                                <input type="text" name="button_text_ar" class="form-control @error('button_text_ar') is-invalid @enderror" value="{{ old('button_text_ar') }}" placeholder="مثال: اقرأ المزيد">
                                @error('button_text_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">نص الزر (إنجليزي)</label>
                                <input type="text" name="button_text_en" class="form-control @error('button_text_en') is-invalid @enderror" value="{{ old('button_text_en') }}" placeholder="Ex: Read More">
                                @error('button_text_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <a href="{{ route('admin.sliders.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الشريحة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
