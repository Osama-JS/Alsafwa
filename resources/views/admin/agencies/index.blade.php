@extends('admin.layouts.master')

@section('title', 'إدارة الوكالات')
@section('page_title', 'الوكالات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الوكالات</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-building"></i></div>
            <div>
                <h4>إدارة الوكالات</h4>
                <p>{{ $stats['total'] }} وكالة — {{ $stats['published'] }} منشورة · {{ $stats['draft'] }} مسودة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.agencies.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> وكالة جديدة
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الوكالات" value="{{ $stats['total'] }}" icon="fas fa-building" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="منشورة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مسودة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.agencies.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (الاسم)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم الوكالة...">
        </div>
        <div class="col-md-6">
            <label class="form-label text-sm">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منشور</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>مؤرشف</option>
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الوكالات</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $agencies->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">الشعار</th>
                    <th width="28%">اسم الوكالة</th>
                    <th width="20%">الموقع الإلكتروني</th>
                    <th width="12%">الحالة</th>
                    <th width="25%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agencies as $agency)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            @if($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="agency"
                                     style="width:52px;height:52px;border-radius:10px;object-fit:contain;background:#f8faff;border:2px solid #e2e8f0;padding:4px;">
                            @else
                                <div class="table-thumb-placeholder"><i class="fas fa-building"></i></div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $agency->name_ar }}</div>
                            <div class="text-xs text-muted">{{ $agency->name_en }}</div>
                        </td>
                        <td>
                            @if($agency->website)
                                <a href="{{ $agency->website }}" target="_blank"
                                   class="d-inline-flex align-items-center gap-1 text-decoration-none"
                                   style="color:#4f46e5;font-size:0.85rem;font-weight:600;">
                                    <i class="fas fa-external-link-alt" style="font-size:0.7rem;"></i> زيارة الموقع
                                </a>
                            @else
                                <span class="text-muted text-sm">—</span>
                            @endif
                        </td>
                        <td>
                            @if($agency->status == 'published')
                                <span class="status-badge published">منشور</span>
                            @elseif($agency->status == 'draft')
                                <span class="status-badge draft">مسودة</span>
                            @else
                                <span class="status-badge" style="background:#f1f5f9;color:#64748b;">مؤرشف</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.agencies.edit', $agency->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.agencies.destroy', $agency->id) }}', '{{ $agency->name_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-building"></i></div>
                                <h6>لا توجد وكالات</h6>
                                <p>لم يتم إضافة أي وكالات بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $agencies->firstItem() ?? 0 }} إلى {{ $agencies->lastItem() ?? 0 }} من أصل {{ $agencies->total() }} سجل</div>
            <div>{{ $agencies->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
