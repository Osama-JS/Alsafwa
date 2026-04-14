@extends('admin.layouts.master')

@section('title', 'إدارة أقسام المعرض')
@section('page_title', 'أقسام معرض الصور')
@section('breadcrumb')
    <li class="breadcrumb-item text-muted"><a href="{{ route('admin.gallery.index') }}">المعرض</a></li>
    <li class="breadcrumb-item active" aria-current="page">الأقسام</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-folder-open"></i></div>
            <div>
                <h4>أقسام المعرض</h4>
                <p>إدارة تصنيفات الصور في معرض الصور</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.gallery.index') }}" class="btn-hero-light">
                <i class="fas fa-arrow-right"></i> العودة للمعرض
            </a>
            <a href="{{ route('admin.gallery-categories.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> قسم جديد
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الأقسام</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $categories->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="25%">الاسم (بالعربية)</th>
                    <th width="25%">الاسم (بالإنجليزية)</th>
                    <th width="10%">الترتيب</th>
                    <th width="15%">الحالة</th>
                    <th width="20%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $category->name_ar }}</div>
                        </td>
                        <td>
                            <div class="text-muted">{{ $category->name_en }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-normal border">{{ $category->order }}</span>
                        </td>
                        <td>
                            <span class="status-badge {{ $category->status == 'active' ? 'published' : 'draft' }}">
                                {{ $category->status == 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.gallery-categories.edit', $category->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.gallery-categories.destroy', $category->id) }}', 'هذا القسم')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                                <h6>لا توجد أقسام</h6>
                                <p>لم يتم إضافة أي أقسام لمعرض الصور بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $categories->firstItem() ?? 0 }} إلى {{ $categories->lastItem() ?? 0 }} من أصل {{ $categories->total() }} سجل</div>
            <div>{{ $categories->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
