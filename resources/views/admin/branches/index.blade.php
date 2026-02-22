@extends('admin.layouts.master')

@section('title', 'إدارة الفروع')
@section('page_title', 'الفروع')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الفروع</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div>
                <h4>إدارة الفروع</h4>
                <p>{{ $stats['total'] }} فرع — {{ $stats['published'] }} مفعل · {{ $stats['draft'] }} غير مفعل</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.branches.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> فرع جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الفروع" value="{{ $stats['total'] }}" icon="fas fa-map-marked-alt" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مفعل" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="غير مفعل" value="{{ $stats['draft'] }}" icon="fas fa-times-circle" color="danger"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.branches.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (الاسم أو العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم الفرع أو العنوان...">
        </div>
        <div class="col-md-6">
            <label class="form-label text-sm">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>مفعل</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير مفعل</option>
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الفروع</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $branches->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="22%">اسم الفرع</th>
                    <th width="28%">العنوان</th>
                    <th width="15%">رقم الهاتف</th>
                    <th width="12%">الحالة</th>
                    <th width="18%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $branch)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-initials orange">
                                    <i class="fas fa-map-marker-alt" style="font-size:0.9rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $branch->name }}</div>
                                    @if($branch->email)
                                        <div class="text-xs text-muted">{{ $branch->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm text-secondary">{{ Str::limit($branch->address_ar, 45) }}</div>
                            @if($branch->map_url)
                                <a href="{{ $branch->map_url }}" target="_blank"
                                   class="text-xs text-decoration-none" style="color:#4f46e5;font-weight:600;">
                                    <i class="fas fa-map-marker-alt me-1"></i> الخريطة
                                </a>
                            @endif
                        </td>
                        <td class="text-sm">
                            @if($branch->phone)
                                <div class="d-flex align-items-center gap-1">
                                    <i class="fas fa-phone-alt text-muted" style="font-size:0.75rem;"></i>
                                    <span>{{ $branch->phone }}</span>
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($branch->status)
                                <span class="status-badge active">مفعل</span>
                            @else
                                <span class="status-badge" style="background:#fee2e2;color:#dc2626;">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#dc2626;display:inline-block;margin-left:4px;"></span>
                                    غير مفعل
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.branches.edit', $branch->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.branches.destroy', $branch->id) }}', '{{ $branch->name }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-map-marked-alt"></i></div>
                                <h6>لا توجد فروع</h6>
                                <p>لم يتم إضافة أي فروع بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $branches->firstItem() ?? 0 }} إلى {{ $branches->lastItem() ?? 0 }} من أصل {{ $branches->total() }} سجل</div>
            <div>{{ $branches->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
