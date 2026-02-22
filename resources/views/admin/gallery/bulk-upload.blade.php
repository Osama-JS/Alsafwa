@extends('admin.layouts.master')

@section('title', 'رفع صور متعددة')
@section('page_title', 'معرض الصور')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">معرض الصور</a></li>
    <li class="breadcrumb-item active" aria-current="page">رفع متعدد</li>
@endsection

@push('styles')
{{-- Dropzone CSS --}}
<link rel="stylesheet" href="https://unpkg.com/dropzone@6/dist/dropzone.css">
<style>
    /* ===== Dropzone Upload Page ===== */
    .upload-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 20px;
        padding: 40px;
        color: #fff;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .upload-hero::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }

    .upload-hero::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -20px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .upload-hero h2 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .upload-hero p {
        opacity: 0.85;
        font-size: 0.95rem;
        margin: 0;
    }

    /* Options Card */
    .options-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        margin-bottom: 24px;
    }

    .options-card .card-header {
        background: #f8faff;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 16px 16px 0 0 !important;
        padding: 18px 24px;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .options-card .card-body {
        padding: 24px;
    }

    /* Dropzone Area */
    .dropzone-wrapper {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    #myDropzone {
        border: 3px dashed #c7d2fe;
        border-radius: 16px;
        background: linear-gradient(135deg, #f8faff 0%, #f0f0ff 100%);
        min-height: 280px;
        padding: 40px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    #myDropzone:hover, #myDropzone.dz-drag-hover {
        border-color: #4f46e5;
        background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%);
        transform: scale(1.005);
    }

    .dropzone .dz-message {
        text-align: center;
        margin: 0;
    }

    .dz-upload-icon {
        font-size: 4rem;
        color: #a5b4fc;
        margin-bottom: 16px;
        display: block;
        transition: all 0.3s ease;
    }

    #myDropzone:hover .dz-upload-icon {
        color: #4f46e5;
        transform: translateY(-5px);
    }

    .dz-upload-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .dz-upload-subtitle {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }

    .dz-upload-btn {
        display: inline-block;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 0 4px 15px rgba(79,70,229,0.3);
    }

    .dz-upload-formats {
        margin-top: 12px;
        font-size: 0.78rem;
        color: #94a3b8;
    }

    /* Preview Thumbnails */
    .dropzone .dz-preview {
        margin: 10px;
    }

    .dropzone .dz-preview .dz-image {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .dropzone .dz-preview .dz-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

    .dropzone .dz-preview .dz-details {
        background: rgba(15, 23, 42, 0.8);
        border-radius: 12px;
    }

    .dropzone .dz-preview.dz-success .dz-image {
        border: 3px solid #10b981;
    }

    .dropzone .dz-preview.dz-error .dz-image {
        border: 3px solid #ef4444;
    }

    .dropzone .dz-preview .dz-success-mark svg,
    .dropzone .dz-preview .dz-error-mark svg {
        width: 40px;
        height: 40px;
    }

    /* Progress Bar */
    .dropzone .dz-preview .dz-progress {
        border-radius: 4px;
        height: 6px;
        background: #e2e8f0;
    }

    .dropzone .dz-preview .dz-progress .dz-upload {
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        border-radius: 4px;
    }

    /* Stats Bar */
    .upload-stats {
        display: flex;
        gap: 20px;
        padding: 16px 24px;
        background: #f8faff;
        border-top: 1px solid #e2e8f0;
        border-radius: 0 0 16px 16px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .stat-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    /* Action Buttons */
    .upload-actions {
        display: flex;
        gap: 12px;
        padding: 20px 24px;
        background: #fff;
        border-top: 1px solid #f1f5f9;
        border-radius: 0 0 16px 16px;
        flex-wrap: wrap;
    }

    .btn-start-upload {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79,70,229,0.35);
    }

    .btn-start-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79,70,229,0.45);
        color: #fff;
    }

    .btn-clear-all {
        background: #fff;
        color: #ef4444;
        border: 1.5px solid #fecaca;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-clear-all:hover {
        background: #fef2f2;
        border-color: #ef4444;
        color: #ef4444;
    }

    /* Upload Result Toast */
    .upload-result {
        position: fixed;
        bottom: 24px;
        left: 24px;
        z-index: 9999;
        min-width: 300px;
    }

    /* Uploaded Gallery Preview */
    .uploaded-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        padding: 20px;
    }

    .uploaded-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        animation: fadeInUp 0.4s ease;
    }

    .uploaded-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .uploaded-item .item-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 10px;
    }

    .uploaded-item:hover .item-overlay {
        opacity: 1;
    }

    .uploaded-item .success-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.7rem;
        box-shadow: 0 2px 6px rgba(16,185,129,0.4);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')

{{-- Hero Banner --}}
<div class="upload-hero">
    <div class="position-relative" style="z-index:1;">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width:56px; height:56px; background:rgba(255,255,255,0.2); border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem;">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <h2 class="mb-0">رفع صور متعددة</h2>
                <p>اسحب وأفلت صورك أو انقر لاختيارها — يمكنك رفع عشرات الصور دفعة واحدة</p>
            </div>
        </div>
        <div class="d-flex gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.15); border-radius:30px; padding:8px 16px; font-size:0.85rem;">
                <i class="fas fa-check-circle"></i> PNG, JPG, GIF, WebP
            </div>
            <div class="d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.15); border-radius:30px; padding:8px 16px; font-size:0.85rem;">
                <i class="fas fa-weight"></i> حد أقصى 5MB لكل صورة
            </div>
            <div class="d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.15); border-radius:30px; padding:8px 16px; font-size:0.85rem;">
                <i class="fas fa-infinity"></i> عدد غير محدود من الصور
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Upload Options --}}
    <div class="col-lg-3">
        <div class="card options-card">
            <div class="card-header">
                <i class="fas fa-sliders-h me-2 text-primary"></i> خيارات الرفع
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-bold small">القسم</label>
                    <select id="upload_category" class="form-select">
                        <option value="">بدون قسم</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted mt-1">سيُطبَّق على جميع الصور المرفوعة</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">الحالة</label>
                    <div class="d-flex flex-column gap-2">
                        <label class="d-flex align-items-center gap-2 p-3 rounded-3 border cursor-pointer" style="cursor:pointer;"
                               onclick="setStatus('published', this)">
                            <input type="radio" name="upload_status" value="published" checked style="display:none;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#10b981; flex-shrink:0;"></span>
                            <span class="fw-semibold small">منشور</span>
                            <i class="fas fa-check ms-auto text-success d-none status-check"></i>
                        </label>
                        <label class="d-flex align-items-center gap-2 p-3 rounded-3 border cursor-pointer" style="cursor:pointer;"
                               onclick="setStatus('draft', this)">
                            <input type="radio" name="upload_status" value="draft" style="display:none;">
                            <span style="width:10px; height:10px; border-radius:50%; background:#f59e0b; flex-shrink:0;"></span>
                            <span class="fw-semibold small">مسودة</span>
                            <i class="fas fa-check ms-auto text-warning d-none status-check"></i>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">إحصائيات الرفع</label>
                    <div class="p-3 rounded-3" style="background:#f8faff; border:1.5px solid #e2e8f0;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">إجمالي الملفات</span>
                            <span class="fw-bold" id="stat_total">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">تم الرفع</span>
                            <span class="fw-bold text-success" id="stat_success">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">فشل</span>
                            <span class="fw-bold text-danger" id="stat_error">0</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.gallery.index') }}" class="btn btn-light w-100 rounded-3">
                    <i class="fas fa-arrow-right me-1"></i> العودة للمعرض
                </a>
            </div>
        </div>
    </div>

    {{-- Dropzone Area --}}
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm dropzone-wrapper">
            <div class="card-body p-0">
                <form id="myDropzone" class="dropzone" action="{{ route('admin.gallery.upload-multiple') }}">
                    @csrf
                    <div class="dz-message">
                        <i class="fas fa-cloud-upload-alt dz-upload-icon"></i>
                        <div class="dz-upload-title">اسحب صورك وأفلتها هنا</div>
                        <div class="dz-upload-subtitle">أو انقر لاختيار الصور من جهازك</div>
                        <span class="dz-upload-btn">
                            <i class="fas fa-folder-open me-2"></i> اختر الصور
                        </span>
                        <div class="dz-upload-formats">
                            PNG · JPG · GIF · WebP · SVG — الحد الأقصى 5MB لكل صورة
                        </div>
                    </div>
                </form>

                {{-- Upload Stats Bar --}}
                <div class="upload-stats" id="uploadStats" style="display:none !important;">
                    <div class="stat-item">
                        <span class="stat-dot" style="background:#4f46e5;"></span>
                        <span id="bar_total">0 ملف</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-dot" style="background:#10b981;"></span>
                        <span id="bar_success">0 ناجح</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-dot" style="background:#ef4444;"></span>
                        <span id="bar_error">0 فشل</span>
                    </div>
                    <div class="ms-auto">
                        <div class="progress" style="width:200px; height:8px; border-radius:4px;">
                            <div class="progress-bar" id="overallProgress" role="progressbar"
                                 style="width:0%; background:linear-gradient(90deg,#4f46e5,#7c3aed); border-radius:4px;"></div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="upload-actions">
                    <button type="button" id="btnStartUpload" class="btn-start-upload btn" onclick="startUpload()">
                        <i class="fas fa-rocket me-2"></i> ابدأ الرفع
                    </button>
                    <button type="button" class="btn-clear-all btn" onclick="clearAll()">
                        <i class="fas fa-trash-alt me-1"></i> مسح الكل
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-light px-4 rounded-3 ms-auto fw-semibold">
                        <i class="fas fa-images me-1"></i> عرض المعرض
                    </a>
                </div>
            </div>
        </div>

        {{-- Uploaded Gallery Preview --}}
        <div class="card border-0 shadow-sm mt-4" id="uploadedGalleryCard" style="display:none; border-radius:16px; overflow:hidden;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    الصور المرفوعة بنجاح
                    <span class="badge rounded-pill ms-2" style="background:#d1fae5; color:#059669;" id="uploadedCount">0</span>
                </h6>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-primary-custom">
                    <i class="fas fa-eye me-1"></i> عرض في المعرض
                </a>
            </div>
            <div class="uploaded-gallery" id="uploadedGallery"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Dropzone JS --}}
<script src="https://unpkg.com/dropzone@6/dist/dropzone-min.js"></script>
<script>
Dropzone.autoDiscover = false;

let successCount = 0;
let errorCount   = 0;
let totalCount   = 0;

const myDropzone = new Dropzone('#myDropzone', {
    url:              '{{ route('admin.gallery.upload-multiple') }}',
    method:           'POST',
    paramName:        'file',
    maxFilesize:      5,        // MB
    acceptedFiles:    'image/*',
    addRemoveLinks:   true,
    autoProcessQueue: false,
    parallelUploads:  3,
    thumbnailWidth:   120,
    thumbnailHeight:  120,
    dictDefaultMessage:       '',
    dictRemoveFile:           '<i class="fas fa-times"></i>',
    dictCancelUpload:         '<i class="fas fa-ban"></i>',
    dictUploadCanceled:       'تم الإلغاء',
    dictFileTooBig:           'الملف كبير جداً (@{{filesize}}MB). الحد الأقصى: @{{maxFilesize}}MB',
    dictInvalidFileType:      'نوع الملف غير مدعوم',
    dictResponseError:        'خطأ في الرفع (@{{statusCode}})',
    dictMaxFilesExceeded:     'تجاوزت الحد الأقصى',

    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },

    // Inject category & status before each upload
    sending: function(file, xhr, formData) {
        formData.append('gallery_category_id', document.getElementById('upload_category').value);
        formData.append('status', document.querySelector('input[name="upload_status"]:checked').value);
    },

    // Track totals
    addedfile: function(file) {
        totalCount++;
        updateStats();
        document.getElementById('uploadStats').style.removeProperty('display');
    },

    success: function(file, response) {
        successCount++;
        updateStats();
        if (response.url) {
            addToGallery(response.url, response.id);
        }
    },

    error: function(file, message) {
        errorCount++;
        updateStats();
        console.error('Upload error:', message);
    },

    queuecomplete: function() {
        const btn = document.getElementById('btnStartUpload');
        btn.innerHTML = '<i class="fas fa-check me-2"></i> اكتمل الرفع';
        btn.style.background = 'linear-gradient(135deg, #059669, #10b981)';

        if (successCount > 0) {
            Swal.fire({
                icon: 'success',
                title: 'تم الرفع بنجاح!',
                html: `تم رفع <strong>${successCount}</strong> صورة بنجاح${errorCount > 0 ? `<br><span class="text-danger">فشل رفع ${errorCount} صورة</span>` : ''}`,
                confirmButtonText: 'عرض المعرض',
                showCancelButton: true,
                cancelButtonText: 'رفع المزيد',
                confirmButtonColor: '#4f46e5',
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('admin.gallery.index') }}';
                }
            });
        }
    },

    removedfile: function(file) {
        if (file.status === 'success') successCount = Math.max(0, successCount - 1);
        else if (file.status === 'error') errorCount = Math.max(0, errorCount - 1);
        totalCount = Math.max(0, totalCount - 1);
        updateStats();
    }
});

function startUpload() {
    if (myDropzone.getQueuedFiles().length === 0) {
        Swal.fire({
            icon: 'info',
            title: 'لا توجد صور',
            text: 'يرجى إضافة صور أولاً قبل بدء الرفع',
            confirmButtonColor: '#4f46e5',
        });
        return;
    }
    const btn = document.getElementById('btnStartUpload');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري الرفع...';
    btn.disabled = true;
    myDropzone.processQueue();
}

function clearAll() {
    myDropzone.removeAllFiles(true);
    successCount = 0;
    errorCount   = 0;
    totalCount   = 0;
    updateStats();
    document.getElementById('btnStartUpload').innerHTML = '<i class="fas fa-rocket me-2"></i> ابدأ الرفع';
    document.getElementById('btnStartUpload').disabled = false;
    document.getElementById('btnStartUpload').style.background = '';
}

function updateStats() {
    document.getElementById('stat_total').textContent   = totalCount;
    document.getElementById('stat_success').textContent = successCount;
    document.getElementById('stat_error').textContent   = errorCount;
    document.getElementById('bar_total').textContent    = totalCount + ' ملف';
    document.getElementById('bar_success').textContent  = successCount + ' ناجح';
    document.getElementById('bar_error').textContent    = errorCount + ' فشل';

    const pct = totalCount > 0 ? Math.round((successCount + errorCount) / totalCount * 100) : 0;
    document.getElementById('overallProgress').style.width = pct + '%';
}

function addToGallery(url, id) {
    const card = document.getElementById('uploadedGalleryCard');
    const gallery = document.getElementById('uploadedGallery');
    const countBadge = document.getElementById('uploadedCount');

    card.style.display = '';

    const item = document.createElement('div');
    item.className = 'uploaded-item';
    item.innerHTML = `
        <img src="${url}" alt="Uploaded">
        <div class="success-badge"><i class="fas fa-check"></i></div>
        <div class="item-overlay">
            <a href="/admin/gallery/${id}/edit" class="btn btn-sm btn-light rounded-pill" style="font-size:0.75rem;">
                <i class="fas fa-edit me-1"></i> تعديل
            </a>
        </div>
    `;
    gallery.appendChild(item);
    countBadge.textContent = gallery.children.length;
}

function setStatus(val, el) {
    document.querySelectorAll('label[onclick^="setStatus"]').forEach(l => {
        l.style.background = '';
        l.style.borderColor = '';
        l.querySelector('.status-check').classList.add('d-none');
    });
    el.style.background = val === 'published' ? '#f0fdf4' : '#fffbeb';
    el.style.borderColor = val === 'published' ? '#10b981' : '#f59e0b';
    el.querySelector('.status-check').classList.remove('d-none');
}

// Init first status label
document.querySelector('label[onclick^="setStatus"]').click();
</script>
@endpush
