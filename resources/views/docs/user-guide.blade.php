@extends('docs.layout')

@section('title', 'دليل المستخدم')

@section('content')
<h1>دليل المستخدم (User Guide)</h1>
<p class="lead mb-5">مرحباً بك في دليل الاستخدام الخاص بلوحة تحكم موقع الصفوة. ستجد هنا شرحاً لكافة الوظائف المتاحة لك.</p>

<div id="auth" class="mb-5">
    <h2>1. الدخول للنظام</h2>
    <p>للوصول للوحة التحكم، اذهب للرابط <code>/admin/login</code></p>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>بيانات الدخول الافتراضية:</strong><br>
        البريد: <code>admin@alsafua.com</code><br>
        كلمة المرور: <code>password</code>
    </div>
</div>

<div id="dashboard" class="mb-5">
    <h2>2. لوحة التحكم الرئيسية (Dashboard)</h2>
    <p>تعرض الواجهة الرئيسية ملخصاً سريعاً عن حالة الموقع:</p>
    <ul>
        <li><strong>عدد الزوار:</strong> زوار اليوم.</li>
        <li><strong>الرسائل الجديدة:</strong> من نموذج "تواصل معنا".</li>
        <li><strong>إحصائيات المحتوى:</strong> عدد الخدمات، الصفحات، والأنشطة المنشورة.</li>
    </ul>
</div>

<div id="content" class="mb-5">
    <h2>3. إدارة المحتوى</h2>
    <p>يمكنك إدارة محتوى الموقع بالكامل من القائمة الجانبية:</p>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="d-flex align-items-start">
                <span class="step-number">أ</span>
                <div>
                    <h4 class="fw-bold">الصفحات (Pages)</h4>
                    <p>لإدارة الصفحات الثابتة مثل "من نحن". تأكد من اختيار "منشور" لتظهر الصفحة في الموقع.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="d-flex align-items-start">
                <span class="step-number">ب</span>
                <div>
                    <h4 class="fw-bold">الخدمات (Services)</h4>
                    <p>إضافة خدمات الشركة مع صور وأيقونات ووصف تفصيلي. الخدمات تظهر في الصفحة الرئيسية وصفحة الخدمات.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="d-flex align-items-start">
                <span class="step-number">ج</span>
                <div>
                    <h4 class="fw-bold">الوكالات (Agencies)</h4>
                    <p>إدارة العلامات التجارية والوكالات التي تمثلها الشركة.</p>
                </div>
            </div>
        </div>
         <div class="col-md-6 mb-3">
            <div class="d-flex align-items-start">
                <span class="step-number">د</span>
                <div>
                    <h4 class="fw-bold">الفروع (Branches)</h4>
                    <p>إضافة فروع الشركة، عناوينها، أوقات العمل، وروابط الخرائط (Google Maps).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="media" class="mb-5">
    <h2>4. معرض الصور</h2>
    <p>من قسم <strong>"معرض الصور"</strong> يمكنك:</p>
    <ol>
        <li>إنشاء تصنيفات للصور (مثل: مشاريع، فعاليات).</li>
        <li>رفع الصور وتعيينها لتصنيف معين.</li>
    </ol>
</div>

<div id="settings" class="mb-5">
    <h2>5. الإعدادات العامة</h2>
    <p>للتحكم في بيانات الموقع الأساسية:</p>
    <ul>
        <li>اسم الموقع وشعاره.</li>
        <li>روابط التواصل الاجتماعي.</li>
        <li>وصف الموقع لمحركات البحث (SEO).</li>
    </ul>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>تنبيه:</strong> عند تغيير الإعدادات، يتم تحديث التخزين المؤقت (Cache) تلقائياً لتظهر التغييرات فوراً للزوار.
    </div>
</div>

<div id="reports" class="mb-5">
    <h2>6. التقارير</h2>
    <p>صفحة تعرض رسوماً بيانية تفصيلية لزيارات الموقع خلال الأسبوع الماضي، والصفحات الأكثر مشاهدة.</p>
</div>
@endsection
