@extends('admin.layouts.master')

@section('title', 'إدارة الموزعين')
@section('page_title', 'الموزعين')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الموزعين</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-truck-loading"></i></div>
            <div>
                <h4>إدارة الموزعين</h4>
                <p>{{ $stats['total'] }} موزع — {{ $stats['active'] }} نشط · {{ $stats['inactive'] }} غير نشط</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.distributors.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> موزع جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الموزعين" value="{{ $stats['total'] }}" icon="fas fa-truck-loading" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="نشط" value="{{ $stats['active'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="غير نشط" value="{{ $stats['inactive'] }}" icon="fas fa-times-circle" color="danger"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.distributors.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (الاسم)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم الموزع العربي أو الإنجليزي...">
        </div>
        <div class="col-md-6">
            <label class="form-label text-sm">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الموزعين</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $distributors->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">الشعار</th>
                    <th width="30%">الموزع</th>
                    <th width="20%">العنوان</th>
                    <th width="10%">الترتيب</th>
                    <th width="10%">الحالة</th>
                    <th width="15%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distributors as $distributor)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            @if($distributor->logo)
                                <img src="{{ asset('storage/' . $distributor->logo) }}" alt="{{ $distributor->name_ar }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: contain; background: #f8fafc; padding: 4px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-truck-loading text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $distributor->name_ar }}</div>
                            <div class="text-xs text-muted mb-1">{{ $distributor->name_en }}</div>
                            <div class="text-xs">
                                <span class="badge bg-soft-info text-info">{{ $distributor->products_count ?? $distributor->products()->count() }} منتج مرتبطة</span>
                            </div>
                        </td>
                        <td class="text-sm">
                            <div>{{ Str::limit($distributor->address_ar, 40) }}</div>
                            @if($distributor->url)
                                <a href="{{ $distributor->url }}" target="_blank" class="text-xs text-primary text-decoration-none"><i class="fas fa-external-link-alt me-1"></i> الموقع الإلكتروني</a>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $distributor->order }}</span></td>
                        <td>
                            <span class="status-badge {{ $distributor->status == 'active' ? 'active' : 'inactive' }}">
                                {{ $distributor->status == 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.distributors.edit', $distributor->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.distributors.destroy', $distributor->id) }}', '{{ $distributor->name_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-truck-loading"></i></div>
                                <h6>لا يوجد موزعين</h6>
                                <p>لم يتم إضافة أي موزعين بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $distributors->firstItem() ?? 0 }} إلى {{ $distributors->lastItem() ?? 0 }} من أصل {{ $distributors->total() }} سجل</div>
            <div>{{ $distributors->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
