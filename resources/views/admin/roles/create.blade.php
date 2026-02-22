@extends('admin.layouts.master')

@section('title', 'إضافة دور جديد')
@section('page_title', 'الأدوار والصلاحيات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">الأدوار</a></li>
    <li class="breadcrumb-item active" aria-current="page">إضافة جديد</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold mb-0">إضافة دور جديد</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <!-- Role Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">اسم الدور <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: editor, moderator" required>
                            <div class="form-text text-muted">يُستخدم هذا الاسم في الكود، يُفضل أن يكون بالإنجليزية وبدون مسافات.</div>
                        </div>

                        <!-- Permissions -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small">الصلاحيات</label>
                            <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <div class="row g-2">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="perm_{{ $permission->id }}"
                                                    name="permission[]"
                                                    value="{{ $permission->name }}"
                                                    {{ in_array($permission->name, old('permission', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleAllPermissions(true)">
                                    <i class="fas fa-check-square me-1"></i> تحديد الكل
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-1" onclick="toggleAllPermissions(false)">
                                    <i class="fas fa-square me-1"></i> إلغاء الكل
                                </button>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-light px-4">إلغاء</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="fas fa-save me-1"></i> حفظ الدور
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
function toggleAllPermissions(check) {
    document.querySelectorAll('input[name="permission[]"]').forEach(cb => cb.checked = check);
}
</script>
@endpush
