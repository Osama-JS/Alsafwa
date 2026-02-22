@extends('admin.layouts.master')

@section('title', 'إدارة الخدمات')
@section('page_title', 'الخدمات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الخدمات</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-concierge-bell"></i></div>
            <div>
                <h4>إدارة الخدمات</h4>
                <p>{{ $stats['total'] }} خدمة — {{ $stats['published'] }} منشورة · {{ $stats['draft'] }} مسودة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.services.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> خدمة جديدة
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الخدمات" value="{{ $stats['total'] }}" icon="fas fa-concierge-bell" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="منشورة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مسودة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.services.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث بعنوان الخدمة...">
        </div>
        <div class="col-md-6">
            <label class="form-label text-sm">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منشور</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الخدمات</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $services->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">الصورة</th>
                    <th width="28%">العنوان</th>
                    <th width="15%">آخر تحديث بواسطة</th>
                    <th width="12%">الحالة</th>
                    <th width="12%">التاريخ</th>
                    <th width="18%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="service" class="table-thumb">
                            @else
                                <div class="table-thumb-placeholder"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $service->title_ar }}</div>
                            <div class="text-xs text-muted">{{ $service->title_en }}</div>
                        </td>
                        <td>
                            @if($service->updatedBy)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-initials">
                                        {{ mb_substr($service->updatedBy->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-secondary">{{ $service->updatedBy->name }}</span>
                                </div>
                            @else
                                <span class="text-muted text-sm">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $service->status }}">
                                {{ $service->status == 'published' ? 'منشور' : 'مسودة' }}
                            </span>
                        </td>
                        <td class="text-sm text-secondary">
                            <i class="far fa-clock me-1"></i> {{ $service->updated_at->format('Y/m/d') }}
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.services.destroy', $service->id) }}', '{{ $service->title_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-concierge-bell"></i></div>
                                <h6>لا توجد خدمات</h6>
                                <p>لم يتم إضافة أي خدمات بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $services->firstItem() ?? 0 }} إلى {{ $services->lastItem() ?? 0 }} من أصل {{ $services->total() }} سجل</div>
            <div>{{ $services->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
