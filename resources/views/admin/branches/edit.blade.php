@extends('admin.layouts.master')

@section('title', 'تعديل الفرع')
@section('page_title', 'الفروع')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.branches.index') }}">الفروع</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل: {{ $branch->name }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات الفرع</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">اسم الفرع <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $branch->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Address -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (عربي) <span class="text-danger">*</span></label>
                                <textarea name="address_ar" class="form-control @error('address_ar') is-invalid @enderror" rows="3" required>{{ old('address_ar', $branch->address_ar) }}</textarea>
                                @error('address_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">العنوان (إنجليزي)</label>
                                <textarea name="address_en" class="form-control @error('address_en') is-invalid @enderror" rows="3">{{ old('address_en', $branch->address_en) }}</textarea>
                                @error('address_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Phone & Email -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الهاتف</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $branch->phone) }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $branch->email) }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">ساعات العمل (عربي)</label>
                                <input type="text" name="working_hours_ar" class="form-control @error('working_hours_ar') is-invalid @enderror" value="{{ old('working_hours_ar', $branch->working_hours_ar) }}">
                                @error('working_hours_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">ساعات العمل (إنجليزي)</label>
                                <input type="text" name="working_hours_en" class="form-control @error('working_hours_en') is-invalid @enderror" value="{{ old('working_hours_en', $branch->working_hours_en) }}">
                                @error('working_hours_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Map URL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">رابط الخريطة (Google Maps)</label>
                            <input type="url" name="map_url" class="form-control @error('map_url') is-invalid @enderror" value="{{ old('map_url', $branch->map_url) }}">
                            @error('map_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Status & Order -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الحالة</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status', $branch->status) == 1 ? 'selected' : '' }}>نشط</option>
                                    <option value="0" {{ old('status', $branch->status) == 0 ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">الترتيب</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $branch->order) }}">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.branches.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> تحديث الفرع
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
