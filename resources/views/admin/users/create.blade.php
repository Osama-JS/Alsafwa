@extends('admin.layouts.master')

@section('title', 'إضافة مستخدم جديد')
@section('page_title', 'المستخدمين')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">بيانات المستخدم الجديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="أدخل الاسم الكامل" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required>
                        </div>

                        <!-- Password -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">كلمة المرور <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                <input type="password" name="confirm-password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">الأدوار (الصلاحيات) <span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-select" multiple required style="min-height: 100px;">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-xs text-muted">اضغط Ctrl لتحديد أكثر من دور</div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ المستخدم
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
