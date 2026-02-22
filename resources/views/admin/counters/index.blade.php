@extends('admin.layouts.master')

@section('title', 'إدارة الإحصائيات')
@section('page_title', 'إحصائيات الشركة')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">إحصائيات الشركة</li>
@endsection

@section('content')
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-tachometer-alt"></i></div>
            <div>
                <h4>إدارة العدادات</h4>
                <p>إدارة الإحصائيات التي تظهر على الصفحة الرئيسية بشكل ديناميكي.</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.counters.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> إضافة عداد جديد
            </a>
        </div>
    </div>

    <div class="table-card mt-4">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة العدادات</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $counters->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">الأيقونة</th>
                    <th width="30%">العنوان</th>
                    <th width="15%">القيمة</th>
                    <th width="10%">الترتيب</th>
                    <th width="12%">الحالة</th>
                    <th width="18%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($counters as $counter)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="table-thumb-placeholder" style="background: var(--accent-light); color: var(--primary-dark);">
                                <i class="{{ $counter->icon ?? 'fas fa-star' }}"></i>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $counter->title_ar }}</div>
                            <div class="text-xs text-muted">{{ $counter->title_en }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-bold" style="font-size: 1rem;">{{ $counter->value }}+</span>
                        </td>
                        <td>
                            <span class="text-secondary fw-bold">{{ $counter->order }}</span>
                        </td>
                        <td>
                            <span class="status-badge {{ $counter->status == 'active' ? 'published' : 'draft' }}">
                                {{ $counter->status == 'active' ? 'نشط' : 'معطل' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.counters.edit', $counter->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.counters.destroy', $counter->id) }}', '{{ $counter->title_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <h6>لا توجد عدادات</h6>
                                <p>لم يتم إضافة أي إحصائيات بعد. أضف أول عداد الآن ليعرض في الواجهة.</p>
                                <a href="{{ route('admin.counters.create') }}" class="btn btn-primary mt-3">إضافة عداد جديد</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container p-3">
            {{ $counters->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
