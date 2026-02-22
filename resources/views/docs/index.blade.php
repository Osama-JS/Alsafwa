@extends('docs.layout')

@section('title', 'نظرة عامة')

@section('content')
<div class="container-fluid">
    <div class="row align-items-center mb-5">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold text-primary mb-3">توثيق مشروع الصفوة</h1>
            <p class="lead text-muted">الدليل الشامل لإدارة وتطوير المنصة الرقمية لشركة الصفوة.</p>
        </div>
        <div class="col-lg-4 text-center">
            <i class="fas fa-book-reader fa-10x text-light"></i>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-body p-4 text-center">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-user-shield fa-4x"></i>
                    </div>
                    <h3 class="card-title fw-bold">دليل المستخدم (Admin)</h3>
                    <p class="card-text text-muted">شرح مفصل لكيفية استخدام لوحة التحكم، إدارة المحتوى، التعامل مع الفروع، الروسائل، والتقارير.</p>
                    <a href="{{ route('docs.user-guide') }}" class="btn btn-primary px-4 rounded-pill">تصفح الدليل</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-body p-4 text-center">
                    <div class="mb-3 text-info">
                        <i class="fas fa-code fa-4x"></i>
                    </div>
                    <h3 class="card-title fw-bold">دليل المطور (Developer)</h3>
                    <p class="card-text text-muted">المعلومات التقنية حول بنية المشروع، قاعدة البيانات، الـ APIs، وكيفية التطوير المستقبلي.</p>
                    <a href="{{ route('docs.developer-guide') }}" class="btn btn-outline-info px-4 rounded-pill">تصفح الدليل التقني</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
