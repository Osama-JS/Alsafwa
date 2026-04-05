@extends('admin.layouts.master')

@section('title', 'تصنيفات الأنشطة')
@section('page_title', 'تصنيفات الأنشطة')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">تصنيفات الأنشطة</li>
@endsection

@section('action_button')
    <a href="{{ route('admin.activity-categories.create') }}" class="btn btn-primary-custom">
        <i class="fas fa-plus me-1"></i> إضافة تصنيف جديد
    </a>
@endsection

@section('content')
    <!-- Filters & Search -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.activity-categories.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="بحث بالاسم (عربي أو إنجليزي)..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light w-100 fw-bold">تصفية</button>
                </div>
                <div class="col-md-2 text-md-start">
                     @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-link link-secondary text-decoration-none p-0 ps-2 small">إعادة تعيين</a>
                     @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 80px;">الترتيب</th>
                            <th class="py-3">التصنيف (عربي)</th>
                            <th class="py-3">التصنيف (إنجليزي)</th>
                            <th class="py-3">عدد الأنشطة</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3 text-center" style="width: 150px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border">{{ $category->order }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $category->name_ar }}</div>
                                    <div class="text-xs text-muted">{{ $category->slug }}</div>
                                </td>
                                <td>{{ $category->name_en }}</td>
                                <td>
                                    <span class="badge bg-soft-info text-info">{{ $category->activities_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($category->status === 'active')
                                        <span class="badge bg-soft-success text-success">
                                            <i class="fas fa-check-circle me-1"></i> نشط
                                        </span>
                                    @else
                                        <span class="badge bg-soft-secondary text-secondary">
                                            <i class="fas fa-times-circle me-1"></i> غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.activity-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary action-btn" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger action-btn" title="حذف" 
                                            onclick="confirmDelete('{{ route('admin.activity-categories.destroy', $category->id) }}', '{{ $category->name_ar }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-info-circle fa-2x mb-3 d-block opacity-25"></i>
                                        لم يتم العثور على أي تصنيفات للأنشطة.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
