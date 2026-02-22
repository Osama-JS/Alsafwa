@extends('admin.layouts.master')

@section('title', 'إدارة معرض الصور')
@section('page_title', 'معرض الصور')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">المعرض</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-photo-video"></i></div>
            <div>
                <h4>معرض الصور</h4>
                <p>{{ $stats['total'] }} صورة — {{ $stats['published'] }} منشورة · {{ $stats['draft'] }} مسودة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.gallery.bulk-upload') }}" class="btn-hero">
                <i class="fas fa-cloud-upload-alt"></i> رفع متعدد
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> صورة جديدة
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الصور" value="{{ $stats['total'] }}" icon="fas fa-images" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="منشورة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="مسودة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.gallery.index')" :expanded="request()->has('search') || request()->has('status') || request()->has('category_id')">
        <div class="col-md-4">
            <label class="form-label text-sm">بحث (العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث بعنوان الصورة...">
        </div>
        <div class="col-md-4">
            <label class="form-label text-sm">التصنيف</label>
            <select name="category_id" class="form-select">
                <option value="">الكل</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name_ar }}
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
            </select>
        </div>
    </x-admin-filter-card>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الصور</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $images->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">الصورة</th>
                    <th width="25%">العنوان</th>
                    <th width="20%">التصنيف</th>
                    <th width="15%">الحالة</th>
                    <th width="20%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($images as $image)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="gallery"
                                     style="width:70px;height:50px;border-radius:10px;object-fit:cover;border:2px solid #e2e8f0;transition:transform 0.2s;"
                                     onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $image->title ?? 'بدون عنوان' }}</div>
                        </td>
                        <td>
                            <span style="background:#f1f5f9;color:#475569;padding:4px 12px;border-radius:20px;font-size:0.78rem;font-weight:600;">
                                {{ optional($image->category)->title_ar ?? 'عام' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $image->status }}">
                                {{ $image->status == 'published' ? 'منشور' : 'مسودة' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.gallery.edit', $image->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.gallery.destroy', $image->id) }}', 'هذه الصورة')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-images"></i></div>
                                <h6>لا توجد صور</h6>
                                <p>لم يتم رفع أي صور بعد — ابدأ بالرفع المتعدد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $images->firstItem() ?? 0 }} إلى {{ $images->lastItem() ?? 0 }} من أصل {{ $images->total() }} سجل</div>
            <div>{{ $images->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
