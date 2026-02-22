@extends('admin.layouts.master')

@section('title', 'تعديل المستخدم')
@section('page_title', 'المستخدمين')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
    <li class="breadcrumb-item active" aria-current="page">تعديل: {{ $user->name }}</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">تحديث بيانات المستخدم</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- Password -->
                        <div class="alert alert-light border text-sm mb-3">
                            <i class="fas fa-info-circle me-1 text-info"></i> اترك حقول كلمة المرور فارغة إذا كنت لا تريد تغييرها.
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">كلمة المرور الجديدة</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">تأكيد كلمة المرور</label>
                                <input type="password" name="confirm-password" class="form-control" placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">الأدوار (الصلاحيات) <span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-select" multiple required style="min-height: 100px;">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text text-xs text-muted">اضغط Ctrl لتحديد أكثر من دور</div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">إلغاء</a>
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
