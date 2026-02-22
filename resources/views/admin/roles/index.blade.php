@extends('admin.layouts.master')

@section('title', 'إدارة الأدوار والصلاحيات')
@section('page_title', 'الأدوار والصلاحيات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الأدوار</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-user-shield"></i></div>
            <div>
                <h4>إدارة الأدوار والصلاحيات</h4>
                <p>{{ $stats['total'] }} دور — {{ $stats['permissions_count'] }} صلاحية متوفرة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.roles.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> دور جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <x-admin-stat-card title="إجمالي الأدوار" value="{{ $stats['total'] }}" icon="fas fa-user-shield" color="primary"/>
        </div>
        <div class="col-md-6">
            <x-admin-stat-card title="إجمالي الصلاحيات" value="{{ $stats['permissions_count'] }}" icon="fas fa-key" color="info"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.roles.index')" :expanded="request()->has('search')">
        <div class="col-md-12">
            <label class="form-label text-sm">بحث (اسم الدور)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم الدور...">
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الأدوار</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $roles->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="22%">اسم الدور</th>
                    <th width="53%">الصلاحيات</th>
                    <th width="20%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initials {{ $role->name == 'Admin' ? '' : 'blue' }}"
                                     style="{{ $role->name == 'Admin' ? 'background:linear-gradient(135deg,#fee2e2,#fecaca);color:#dc2626;' : '' }}">
                                    <i class="fas {{ $role->name == 'Admin' ? 'fa-crown' : 'fa-user-tag' }}" style="font-size:0.9rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $role->name }}</div>
                                    @if($role->name == 'Admin')
                                        <span class="status-badge" style="background:#fee2e2;color:#dc2626;font-size:0.7rem;padding:2px 8px;">مسؤول النظام</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($role->permissions->take(6) as $permission)
                                    <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:600;border:1px solid #e2e8f0;">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                                @if($role->permissions->count() > 6)
                                    <span style="background:#ede9fe;color:#4f46e5;padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">
                                        +{{ $role->permissions->count() - 6 }} أخرى
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.roles.show', $role->id) }}" class="action-btn action-btn-view">
                                    <i class="fas fa-eye"></i> عرض
                                </a>
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                @if($role->name != 'Admin')
                                    <button type="button" class="action-btn action-btn-delete"
                                            onclick="confirmDelete('{{ route('admin.roles.destroy', $role->id) }}', '{{ $role->name }}')">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-user-shield"></i></div>
                                <h6>لا توجد أدوار</h6>
                                <p>لم يتم إضافة أي أدوار بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $roles->firstItem() ?? 0 }} إلى {{ $roles->lastItem() ?? 0 }} من أصل {{ $roles->total() }} سجل</div>
            <div>{{ $roles->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
