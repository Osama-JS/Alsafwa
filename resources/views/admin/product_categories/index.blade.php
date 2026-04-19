@extends('admin.layouts.master')

@section('title', 'أقسام المنتجات')
@section('page_title', 'أقسام المنتجات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item active" aria-current="page">الأقسام</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-cubes"></i></div>
            <div>
                <h4>أقسام المنتجات</h4>
                <p>إدارة تصنيفات المنتجات وتنظيمها</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.products.index') }}" class="btn-hero-light">
                <i class="fas fa-arrow-right"></i> العودة للمنتجات
            </a>
            <a href="{{ route('admin.product-categories.create') }}" class="btn-hero-solid">
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
                    <th width="20%">الاسم (بالعربية)</th>
                    <th width="20%">الاسم (بالإنجليزية)</th>
                    <th width="15%">القسم الأب</th>
                    <th width="10%">عدد المنتجات</th>
                    <th width="10%">الترتيب</th>
                    <th width="10%">الحالة</th>
                    <th width="10%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <div class="fw-bold text-dark">
                                @if($category->parent_id)
                                    <i class="fas fa-level-down-alt fa-rotate-180 text-muted me-2" style="font-size: 0.8rem;"></i>
                                @endif
                                {{ $category->name_ar }}
                            </div>
                        </td>
                        <td>
                            <div class="text-muted">{{ $category->name_en }}</div>
                        </td>
                        <td>
                            @if($category->parent)
                                <span class="badge bg-soft-primary text-primary border-primary border-opacity-10" style="font-size: 0.75rem;">
                                    <i class="fas fa-folder me-1"></i> {{ $category->parent->name_ar }}
                                </span>
                            @else
                                <span class="text-muted small">---</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-bold border" style="font-size: 0.8rem;">
                                {{ $category->products_count }} <i class="fas fa-box text-muted ms-1"></i>
                            </span>
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
                                <a href="{{ route('admin.product-categories.edit', $category->id) }}" class="action-btn action-btn-edit" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="action-btn action-btn-delete" title="حذف"
                                        onclick="confirmDelete('{{ route('admin.product-categories.destroy', $category->id) }}', 'هذا القسم')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-cubes"></i></div>
                                <h6>لا توجد أقسام</h6>
                                <p>لم يتم إضافة أي أقسام للمنتجات بعد</p>
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
