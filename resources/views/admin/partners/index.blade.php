@extends('admin.layouts.master')

@section('title', 'إدارة الشركاء')
@section('page_title', 'الشركاء')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الشركاء</li>
@endsection

@section('content')
    {{-- Page Hero --}}
    <div class="page-hero">
        <div class="d-flex align-items-center" style="position:relative;z-index:1;">
            <div class="page-hero-icon"><i class="fas fa-handshake"></i></div>
            <div>
                <h4>إدارة الشركاء</h4>
                <p>{{ $stats['total'] }} شريك — {{ $stats['active'] }} نشط · {{ $stats['inactive'] }} غير نشط</p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('admin.partners.create') }}" class="btn-hero-solid">
                <i class="fas fa-plus"></i> شريك جديد
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <x-admin-stat-card title="إجمالي الشركاء" value="{{ $stats['total'] }}" icon="fas fa-handshake" color="primary"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="نشط" value="{{ $stats['active'] }}" icon="fas fa-check-circle" color="success"/>
        </div>
        <div class="col-md-4">
            <x-admin-stat-card title="غير نشط" value="{{ $stats['inactive'] }}" icon="fas fa-times-circle" color="danger"/>
        </div>
    </div>

    {{-- Filter --}}
    <x-admin-filter-card :action="route('admin.partners.index')" :expanded="request()->has('search') || request()->has('status')">
        <div class="col-md-6">
            <label class="form-label text-sm">بحث (الاسم)</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="ابحث باسم الشريك العربي أو الإنجليزي...">
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
            <h6><i class="fas fa-list me-2 text-primary"></i> قائمة الشركاء</h6>
            <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:0.8rem;padding:6px 12px;border-radius:20px;">
                {{ $partners->total() }} سجل
            </span>
        </div>
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="10%">الشعار</th>
                    <th width="30%">الاسم</th>
                    <th width="15%">الحالة</th>
                    <th width="10%">الترتيب</th>
                    <th width="15%" class="text-end">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td><div class="row-num">{{ $loop->iteration }}</div></td>
                        <td>
                            @if($partner->logo)
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name_ar }}" class="rounded shadow-sm" style="width: 50px; height: 40px; object-fit: contain; background: #f8fafc; padding: 4px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $partner->name_ar }}</div>
                            <div class="text-xs text-muted">{{ $partner->name_en }}</div>
                            @if($partner->url)
                                <div class="text-xs text-primary mt-1"><i class="fas fa-link me-1"></i> {{ Str::limit($partner->url, 30) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $partner->status == 'active' ? 'active' : 'inactive' }}">
                                {{ $partner->status == 'active' ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $partner->order }}</span></td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.partners.edit', $partner->id) }}" class="action-btn action-btn-edit">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <button type="button" class="action-btn action-btn-delete"
                                        onclick="confirmDelete('{{ route('admin.partners.destroy', $partner->id) }}', '{{ $partner->name_ar }}')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-handshake"></i></div>
                                <h6>لا يوجد شركاء</h6>
                                <p>لم يتم إضافة أي شركاء بعد</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            <div class="text-muted text-sm">عرض {{ $partners->firstItem() ?? 0 }} إلى {{ $partners->lastItem() ?? 0 }} من أصل {{ $partners->total() }} سجل</div>
            <div>{{ $partners->withQueryString()->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection
