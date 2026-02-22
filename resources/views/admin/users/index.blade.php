@extends('admin.layouts.master')

@section('title', 'إدارة المستخدمين')
@section('page_title', 'المستخدمين')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">المستخدمين</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-users"></i></div>
            <div>
                <h4>إدارة المستخدمين</h4>
                <p>{{ $stats['total'] }} مستخدم مسجل — {{ $stats['admins'] }} مسؤول</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.users.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> مستخدم جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي المستخدمين" value="{{ $stats['total'] }}" icon="fas fa-users" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="المسؤولين" value="{{ $stats['admins'] }}" icon="fas fa-user-shield" color="danger"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="تسجيلات اليوم" value="{{ $stats['new_today'] }}" icon="fas fa-user-plus" color="success"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.users.index')" :expanded="request()->has('search') || request()->has('role')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (الاسم أو البريد)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث هنا...">
        </div>
        <div class="col-md-6">
            <label class="form-label text-sm">الدور</label>
            <select name="role" class="form-select">
                <option value="">الكل</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة المستخدمين</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $users->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="35%">المستخدم</th>
                    <th width="25%">الدور</th>
                    <th width="20%">تاريخ التسجيل</th>
                    <th width="15%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initials">{{ mb_substr($user->name, 0, 1) }}</div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-xs text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @foreach($user->getRoleNames() as $v)
                                <span class="status-badge {{ $v == 'Admin' ? '' : 'active' }}"
                                      style="{{ $v == 'Admin' ? 'background:#fee2e2;color:#991b1b;' : '' }}">
                                    {{ $v }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <div class="text-sm text-secondary">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $user->created_at->format('Y/m/d') }}
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.users.destroy', $user->id) }}', '{{ $user->name }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                                <h6>لا يوجد مستخدمون</h6>
                                <p>لم يتم إضافة أي مستخدمين بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $users->firstItem() ?? 0 }} إلى {{ $users->lastItem() ?? 0 }} من أصل {{ $users->total() }} سجل</div>
            <div>{{ $users->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
