@extends('admin.layouts.master')

@section('title', 'إدارة الصفحات')
@section('page_title', 'الصفحات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الصفحات</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-file-alt"></i></div>
            <div>
                <h4>إدارة الصفحات</h4>
                <p>{{ $stats['total'] }} صفحة — {{ $stats['published'] }} منشورة · {{ $stats['draft'] }} مسودة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.pages.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> صفحة جديدة
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الصفحات" value="{{ $stats['total'] }}" icon="fas fa-file-alt" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="منشورة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مسودة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.pages.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث بالعنوان العربي أو الإنجليزي...">
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
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الصفحات</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $pages->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="35%">العنوان</th>
                    <th width="15%">الحالة</th>
                    <th width="15%">آخر تحديث</th>
                    <th width="15%">بواسطة</th>
                    <th width="15%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $page->title_ar }}</div>
                            <div class="text-xs text-muted">{{ $page->title_en }}</div>
                        </td>
                        <td>
                            <span class="status-badge {{ $page->status }}">
                                {{ $page->status == 'published' ? 'منشور' : 'مسودة' }}
                            </span>
                        </td>
                        <td class="text-sm text-secondary">
                            <i class="far fa-clock me-1"></i> {{ $page->updated_at->format('Y/m/d') }}
                        </td>
                        <td class="text-sm">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initials green" style="width:28px;height:28px;font-size:0.75rem;border-radius:8px;">
                                    {{ mb_substr(optional($page->updater)->name ?? '?', 0, 1) }}
                                </div>
                                {{ optional($page->updater)->name ?? 'غير معروف' }}
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.pages.destroy', $page->id) }}', '{{ $page->title_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-file-alt"></i></div>
                                <h6>لا توجد صفحات</h6>
                                <p>لم يتم إضافة أي صفحات بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $pages->firstItem() ?? 0 }} إلى {{ $pages->lastItem() ?? 0 }} من أصل {{ $pages->total() }} سجل</div>
            <div>{{ $pages->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
