@extends('admin.layouts.master')

@section('title', 'إدارة الأنشطة والفعاليات')
@section('page_title', 'الأنشطة والفعاليات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الأنشطة</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h4>إدارة الأنشطة والفعاليات</h4>
                <p>{{ $stats['total'] }} نشاط — {{ $stats['published'] }} منشور · {{ $stats['draft'] }} مسودة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.activities.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> نشاط جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الأنشطة" value="{{ $stats['total'] }}" icon="fas fa-clipboard-list" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="منشورة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مسودة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.activities.index')" :expanded="request()->has('search') || request()->has('status') || request()->has('category_id')">
        <div class="col-md-4">
            <label class="form-label text-sm">بحث (العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث بالعنوان...">
        </div>
        <div class="col-md-4">
            <label class="form-label text-sm">التصنيف</label>
            <select name="category_id" class="form-select">
                <option value="">الكل</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title_ar }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
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
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الأنشطة</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $activities->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="8%">الصورة</th>
                    <th width="28%">العنوان</th>
                    <th width="15%">التصنيف</th>
                    <th width="12%">الحالة</th>
                    <th width="15%">آخر تحديث</th>
                    <th width="17%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            @if($activity->image)
                                <img src="{{ asset('storage/' . $activity->image) }}" alt="activity" class="table-thumb">
                            @else
                                <div class="table-thumb-placeholder"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $activity->title_ar }}</div>
                        </td>
                        <td>
                            <span style="background:#f1f5f9;color:#475569;padding:4px 10px;border-radius:20px;font-size:0.78rem;font-weight:600;">
                                {{ optional($activity->category)->title_ar ?? 'عام' }}
                            </span>
                        </td>
                        <td>
                            @if($activity->status == 'published')
                                <span class="status-badge published">منشور</span>
                            @elseif($activity->status == 'draft')
                                <span class="status-badge draft">مسودة</span>
                            @else
                                <span class="status-badge" style="background:#f1f5f9;color:#64748b;">مؤرشف</span>
                            @endif
                        </td>
                        <td class="text-sm text-secondary">
                            <i class="far fa-clock me-1"></i> {{ $activity->updated_at->format('Y/m/d') }}
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.activities.edit', $activity->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.activities.destroy', $activity->id) }}', '{{ $activity->title_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-clipboard-list"></i></div>
                                <h6>لا توجد أنشطة</h6>
                                <p>لم يتم إضافة أي أنشطة بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $activities->firstItem() ?? 0 }} إلى {{ $activities->lastItem() ?? 0 }} من أصل {{ $activities->total() }} سجل</div>
            <div>{{ $activities->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
