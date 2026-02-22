@extends('admin.layouts.master')

@section('title', 'تعديل النشاط')
@section('page_title', 'الأنشطة')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">الأنشطة</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل: {{ $activity->title_ar }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات النشاط</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Titles -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي) <span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar', $activity->title_ar) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي)</label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $activity->title_en) }}">
                            </div>
                        </div>

                        <!-- Image & Category -->
                        <div class="row g-3 mb-4">
                             <div class="col-md-6">
                                <label class="form-label fw-bold small">صورة النشاط</label>
                                <input type="file" name="image" class="form-control" onchange="previewImage(this, 'activity-preview')">
                                <div class="mt-2">
                                    @if($activity->image)
                                        <img id="activity-preview" src="{{ asset('storage/' . $activity->image) }}" alt="Preview" style="max-width: 100%; height: auto; max-height: 200px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <img id="activity-preview" src="#" alt="Preview" style="display: none; max-width: 100%; height: auto; max-height: 200px; border-radius: 8px; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">التصنيف</label>
                                <select name="activity_category_id" class="form-select">
                                    <option value="">اختر التصنيف</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $activity->activity_category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (عربي)</label>
                                <textarea name="description_ar" class="form-control" rows="4">{{ old('description_ar', $activity->description_ar) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">وصف (إنجليزي)</label>
                                <textarea name="description_en" class="form-control" rows="4">{{ old('description_en', $activity->description_en) }}</textarea>
                            </div>
                        </div>

                        <!-- Video URL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">رابط فيديو (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $activity->video_url) }}">
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select">
                                    <option value="published" {{ $activity->status == 'published' ? 'selected' : '' }}>منشور</option>
                                    <option value="draft" {{ $activity->status == 'draft' ? 'selected' : '' }}>مسودة</option>
                                    <option value="archived" {{ $activity->status == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', $activity->order) }}">
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.activities.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث النشاط
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
