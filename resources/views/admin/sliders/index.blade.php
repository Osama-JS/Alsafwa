@extends('admin.layouts.master')

@section('title', 'إدارة السلايدر')
@section('page_title', 'السلايدر')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">السلايدر</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-images"></i></div>
            <div>
                <h4>إدارة السلايدر</h4>
                <p>{{ $stats['total'] }} شريحة — {{ $stats['published'] }} نشطة · {{ $stats['draft'] }} غير نشطة</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.sliders.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> شريحة جديدة
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الشرائح" value="{{ $stats['total'] }}" icon="fas fa-images" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="نشطة" value="{{ $stats['published'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="غير نشطة" value="{{ $stats['draft'] }}" icon="fas fa-pen-square" color="warning"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.sliders.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (العنوان)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث بالعنوان الرئيسي أو الفرعي...">
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
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الشرائح</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $sliders->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">الصورة</th>
                    <th width="30%">العنوان</th>
                    <th width="8%">الترتيب</th>
                    <th width="12%">الحالة</th>
                    <th width="15%">آخر تحديث</th>
                    <th width="15%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="slider"
                                 style="width:90px;height:50px;border-radius:10px;object-fit:cover;border:2px solid #e2e8f0;transition:transform 0.2s;"
                                 onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $slider->title_ar ?? 'بدون عنوان' }}</div>
                            <div class="text-xs text-muted">{{ Str::limit($slider->title_en, 50) }}</div>
                        </td>
                        <td>
                            <span style="background:#ede9fe;color:#4f46e5;padding:4px 10px;border-radius:20px;font-size:0.8rem;font-weight:700;">
                                {{ $slider->order ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $slider->status }}">
                                {{ $slider->status == 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td class="text-sm text-secondary">
                            <i class="far fa-clock me-1"></i> {{ $slider->updated_at->format('Y/m/d') }}
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.sliders.destroy', $slider->id) }}', '{{ $slider->title_ar ?? 'هذه الشريحة' }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-images"></i></div>
                                <h6>لا يوجد شرائح</h6>
                                <p>لم يتم إضافة أي شرائح بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $sliders->firstItem() ?? 0 }} إلى {{ $sliders->lastItem() ?? 0 }} من أصل {{ $sliders->total() }} سجل</div>
            <div>{{ $sliders->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
