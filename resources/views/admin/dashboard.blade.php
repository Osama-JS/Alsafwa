@extends('admin.layouts.master')

@section('title', 'لوحة التحكم الرئيسية')
@section('page_title', 'الرئيسية')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">لوحة المعلومات</li>
@endsection

@section('content')
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm bg-primary text-white mb-4 overflow-hidden position-relative">
        <div class="card-body p-4 position-relative z-1">
            <h2 class="fw-bold mb-2">مرحباً بك، {{ auth()->user()->name }} 👋</h2>
            <p class="mb-0 opacity-75">إليك نظرة عامة على أداء الموقع اليوم.</p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-n3">
            <i class="fas fa-chart-line fa-8x"></i>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <x-admin-stat-card
                title="إجمالي الصفحات"
                value="{{ $stats['pages'] ?? 0 }}"
                icon="fas fa-file-alt"
                color="primary"
                link="{{ route('admin.pages.index') }}"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="إجمالي الخدمات"
                value="{{ $stats['services'] ?? 0 }}"
                icon="fas fa-concierge-bell"
                color="info"
                link="{{ route('admin.services.index') }}"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="الرسائل الجديدة"
                value="{{ $stats['messages'] ?? 0 }}"
                icon="fas fa-envelope"
                color="warning"
                link="#"
            />
        </div>
        <div class="col-md-3">
            <x-admin-stat-card
                title="زيارات اليوم"
                value="{{ $stats['visitors_today'] ?? 0 }}"
                icon="fas fa-users"
                color="success"
                link="{{ route('admin.reports.index') }}"
            />
        </div>
    </div>

    <!-- Quick Actions & Recent Activity Placeholder -->
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h5 class="card-title fw-bold text-secondary mb-0">روابط سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-light w-100 py-3 text-start border shadow-sm">
                                <i class="fas fa-plus-circle text-primary me-2 f-lg"></i>
                                <span class="fw-bold text-dark">إضافة صفحة</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.services.create') }}" class="btn btn-light w-100 py-3 text-start border shadow-sm">
                                <i class="fas fa-plus-circle text-info me-2 f-lg"></i>
                                <span class="fw-bold text-dark">إضافة خدمة</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-light w-100 py-3 text-start border shadow-sm">
                                <i class="fas fa-cogs text-secondary me-2 f-lg"></i>
                                <span class="fw-bold text-dark">الإعدادات العامة</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 bg-light border-0">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <i class="fas fa-rocket text-primary fa-3x mb-3"></i>
                    <h5 class="fw-bold">هل تحتاج مساعدة؟</h5>
                    <p class="text-muted text-sm px-3">تواصل مع الدعم الفني للحصول على المساعدة في إدارة لوحة التحكم.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
