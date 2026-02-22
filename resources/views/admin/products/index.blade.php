@extends('admin.layouts.master')

@section('title', 'إدارة المنتجات')
@section('page_title', 'المنتجات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">المنتجات</li>
@endsection

@section('content')

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#ede9fe;">
                        <i class="fas fa-box text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">إجمالي المنتجات</div>
                        <div class="fw-bold fs-5">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#d1fae5;">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">نشط</div>
                        <div class="fw-bold fs-5">{{ $stats['active'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:50px;height:50px;background:#fef3c7;">
                        <i class="fas fa-eye-slash text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">غير نشط</div>
                        <div class="fw-bold fs-5">{{ $stats['inactive'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form class="d-flex gap-2" method="GET">
                <input type="text" name="search" class="form-control" placeholder="ابحث بالاسم..." value="{{ request('search') }}" style="width:220px;">
                <select name="status" class="form-select" style="width:140px;" onchange="this.form.submit()">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                <button type="submit" class="btn btn-primary-custom"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
                <i class="fas fa-plus me-1"></i> إضافة منتج
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>الصورة</th>
                            <th>العنوان (عربي)</th>
                            <th>العنوان (إنجليزي)</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>الوكالة</th>
                            <th>الحالة</th>
                            <th style="width:130px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded-3" style="width:60px;height:60px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ Str::limit($product->title_ar, 30) }}</td>
                                <td>{{ Str::limit($product->title_en, 30) }}</td>
                                <td>{{ $product->price ? number_format($product->price, 2) . ' ر.س' : '—' }}</td>
                                <td>{{ $product->discount ? number_format($product->discount, 2) . ' ر.س' : '—' }}</td>
                                <td>{{ $product->agency ? $product->agency->name_ar : '—' }}</td>
                                <td>
                                    @if($product->status === 'active')
                                        <span class="badge rounded-pill" style="background:#d1fae5;color:#059669;">نشط</span>
                                    @else
                                        <span class="badge rounded-pill" style="background:#fef3c7;color:#d97706;">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fs-1 mb-3 d-block opacity-25"></i>
                                    لا توجد منتجات حالياً
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $products->links() }}</div>

@endsection
