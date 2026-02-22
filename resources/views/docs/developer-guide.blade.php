@extends('docs.layout')

@section('title', 'دليل المطور')

@section('content')
<h1>دليل المطور (Developer Guide)</h1>
<p class="lead mb-5">التوثيق التقني لمشروع الصفوة، يشمل البنية البرمجية، قاعدة البيانات، وأوامر التشغيل.</p>

<div id="tech-stack" class="mb-5">
    <h2>1. التقنيات المستخدمة (Stack)</h2>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Framework:</strong> Laravel 12</li>
        <li class="list-group-item"><strong>PHP Version:</strong> ^8.2</li>
        <li class="list-group-item"><strong>Database:</strong> MySQL</li>
        <li class="list-group-item"><strong>Frontend:</strong> Bootstrap 5 (RTL Support)</li>
        <li class="list-group-item"><strong>Template:</strong> AdminLTE 3 (Dashboard)</li>
        <li class="list-group-item"><strong>Localization:</strong> mcamara/laravel-localization</li>
    </ul>
</div>

<div id="installation" class="mb-5">
    <h2>2. التثبيت والتشغيل وتوليد البيانات الوهمية (Seeding)</h2>
    <pre><code class="language-bash">
# 1. Clone & Install
git clone [repo_url]
cd alsafua
composer install
npm install && npm run build

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Database & Seeding
# تأكد من إعداد قاعدة البيانات في .env أولاً
php artisan migrate --seed
    </code></pre>
    <div class="alert alert-info">
        <strong>Seeding:</strong> الأمر <code>migrate --seed</code> سيقوم بإنشاء الأدوار، الصلاحيات، المستخدم الأساسي، وبعض البيانات التجريبية.
    </div>
</div>

<div id="structure" class="mb-5">
    <h2>3. هيكلية المشروع</h2>
    <h3>Controllers</h3>
    <ul>
        <li><code>App\Http\Controllers\Admin\*</code>: وحدات التحكم الخاصة بلوحة الإدارة (محمية بـ Middleware).</li>
        <li><code>App\Http\Controllers\*</code>: وحدات التحكم للواجهة الأمامية.</li>
        <li><code>DocumenationController</code>: لعرض هذا التوثيق.</li>
    </ul>

    <h3>Models</h3>
    <p>أهم الـ Models والعلاقات:</p>
    <ul>
        <li><code>User</code>: يستخدم Trait <code>HasRoles</code> من Spatie.</li>
        <li><code>GalleryImage</code> ينتمي إلى <code>GalleryCategory</code>.</li>
        <li><code>Activity</code> ينتمي إلى <code>ActivityCategory</code>.</li>
    </ul>
</div>

<div id="seo" class="mb-5">
    <h2>4. SEO & Performance</h2>
    <p>المشروع مجهز بعدة تحسينات:</p>
    <ul>
        <li><strong>Sitemap:</strong> يتم توليدها بالأمر: <code>php artisan sitemap:generate</code></li>
        <li><strong>Caching:</strong> يتم تخزين الإعدادات باستخدام <code>Cache::rememberForever</code>.</li>
        <li><strong>MinifyHtml:</strong> Middleware مخصص لضغط مخرجات الـ HTML.</li>
    </ul>
</div>

<div id="commands" class="mb-5">
    <h2>5. أوامر مفيدة (Artisan Commands)</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الأمر</th>
                <th>الوصف</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>php artisan sitemap:generate</code></td>
                <td>تحديث خريطة الموقع sitemap.xml</td>
            </tr>
             <tr>
                <td><code>php artisan optimize:clear</code></td>
                <td>مسح جميع أنواع الكاش</td>
            </tr>
            <tr>
                <td><code>php artisan storage:link</code></td>
                <td>ربط مجلد التخزين بالعام</td>
            </tr>
        </tbody>
    </table>
</div>

<div id="contact" class="mb-5">
    <h2>6. الدعم والمساعدة</h2>
    <p>لأي استفسارات تقنية، يرجى مراجعة فريق التطوير أو فتح Issue في المستودع.</p>
</div>
@endsection
