@extends('admin.layouts.master')

@section('title', 'الإعدادات العامة')
@section('page_title', 'الإعدادات')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">الإعدادات</li>
@endsection

@push('styles')
<style>
    /* ===== Settings Page Styles ===== */
    .settings-sidebar {
        position: sticky;
        top: 80px;
    }

    .settings-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.25s ease;
        border: none;
        background: transparent;
        margin-bottom: 4px;
        text-align: right;
    }

    .settings-nav .nav-link:hover {
        background: #f1f5f9;
        color: #334155;
        transform: translateX(-3px);
    }

    .settings-nav .nav-link.active {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
    }

    .settings-nav .nav-link .nav-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .settings-nav .nav-link.active .nav-icon {
        background: rgba(255,255,255,0.25);
        color: #fff;
    }

    .settings-section-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 24px;
        transition: box-shadow 0.3s ease;
    }

    .settings-section-card:hover {
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
    }

    .settings-section-header {
        padding: 20px 28px;
        background: linear-gradient(135deg, #f8faff 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .settings-section-header .section-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .settings-section-header h6 {
        font-weight: 700;
        font-size: 1rem;
        color: #1e293b;
        margin: 0;
    }

    .settings-section-header p {
        font-size: 0.8rem;
        color: #94a3b8;
        margin: 2px 0 0;
    }

    .settings-section-body {
        padding: 28px;
    }

    .setting-field {
        margin-bottom: 24px;
    }

    .setting-field:last-child {
        margin-bottom: 0;
    }

    .setting-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .setting-label .label-badge {
        font-size: 0.65rem;
        padding: 2px 7px;
        border-radius: 20px;
        font-weight: 600;
    }

    .setting-hint {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: #fafbfc;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        background: #fff;
    }

    /* Image Upload Zone */
    .image-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8faff;
        position: relative;
    }

    .image-upload-zone:hover {
        border-color: #4f46e5;
        background: #f0f0ff;
    }

    .image-upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .image-upload-zone .upload-icon {
        font-size: 2rem;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .image-upload-zone .upload-text {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    .image-upload-zone .upload-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    .image-preview-box {
        position: relative;
        display: inline-block;
        margin-top: 12px;
    }

    .image-preview-box img {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        object-fit: contain;
        background: #f8faff;
    }

    .image-preview-box .remove-preview {
        position: absolute;
        top: -8px;
        left: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #ef4444;
        color: #fff;
        border: none;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(239,68,68,0.4);
    }

    /* Color Picker */
    .color-picker-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .color-picker-wrapper input[type="color"] {
        width: 48px;
        height: 42px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 3px;
        cursor: pointer;
        background: #fafbfc;
    }

    /* Toggle Switch */
    .toggle-setting {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #f8faff;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
    }

    .toggle-setting .toggle-info h6 {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .toggle-setting .toggle-info p {
        font-size: 0.78rem;
        color: #94a3b8;
        margin: 2px 0 0;
    }

    .form-switch .form-check-input {
        width: 48px;
        height: 26px;
        cursor: pointer;
    }

    .form-switch .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    /* Save Button */
    .settings-save-bar {
        position: sticky;
        bottom: 20px;
        z-index: 100;
        margin-top: 24px;
    }

    .settings-save-bar .save-card {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 16px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    .settings-save-bar .save-card .save-info {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .settings-save-bar .save-card .save-info strong {
        color: #fff;
        display: block;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .btn-save-settings {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
    }

    .btn-save-settings:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.5);
        color: #fff;
    }

    /* Section Divider */
    .settings-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: 20px 0;
    }

    /* Char Counter */
    .char-counter {
        font-size: 0.75rem;
        color: #94a3b8;
        text-align: left;
        margin-top: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .settings-sidebar {
            position: static;
            margin-bottom: 20px;
        }
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
    @csrf

    <div class="row g-4">
        <!-- ===== Sidebar Navigation ===== -->
        <div class="col-lg-3">
            <div class="settings-sidebar">
                <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden;">
                    <div class="card-body p-3">
                        <p class="text-xs text-muted fw-bold text-uppercase mb-3 px-2" style="letter-spacing:1px;">أقسام الإعدادات</p>
                        <nav class="settings-nav nav flex-column">
                            @php
                                $groupIcons = [
                                    'general'  => ['icon' => 'fas fa-globe',        'label' => 'الإعدادات العامة',   'color' => '#4f46e5', 'bg' => '#ede9fe'],
                                    'contact'  => ['icon' => 'fas fa-phone-alt',    'label' => 'معلومات التواصل',    'color' => '#0891b2', 'bg' => '#e0f2fe'],
                                    'social'   => ['icon' => 'fas fa-share-alt',    'label' => 'التواصل الاجتماعي', 'color' => '#059669', 'bg' => '#d1fae5'],
                                    'seo'      => ['icon' => 'fas fa-search',       'label' => 'تحسين محركات البحث', 'color' => '#d97706', 'bg' => '#fef3c7'],
                                    'appearance'=> ['icon' => 'fas fa-palette',     'label' => 'المظهر والتصميم',    'color' => '#db2777', 'bg' => '#fce7f3'],
                                    'email'    => ['icon' => 'fas fa-envelope',     'label' => 'إعدادات البريد',     'color' => '#7c3aed', 'bg' => '#ede9fe'],
                                    'counters' => ['icon' => 'fas fa-tachometer-alt', 'label' => 'إحصائيات الشركة', 'color' => '#10b981', 'bg' => '#d1fae5'],
                                    'advanced' => ['icon' => 'fas fa-cogs',         'label' => 'إعدادات متقدمة',     'color' => '#374151', 'bg' => '#f3f4f6'],
                                ];
                            @endphp

                            @foreach($settings as $group => $groupSettings)
                                @php
                                    $meta = $groupIcons[$group] ?? ['icon' => 'fas fa-sliders-h', 'label' => ucfirst($group), 'color' => '#4f46e5', 'bg' => '#ede9fe'];
                                @endphp
                                <a href="#section-{{ $group }}" class="nav-link {{ $loop->first ? 'active' : '' }}" data-section="{{ $group }}" onclick="scrollToSection('{{ $group }}', this)">
                                    <span class="nav-icon" style="background:{{ $meta['bg'] }}; color:{{ $meta['color'] }};">
                                        <i class="{{ $meta['icon'] }}"></i>
                                    </span>
                                    <span>{{ $meta['label'] }}</span>
                                    <span class="badge rounded-pill ms-auto" style="background:{{ $meta['bg'] }}; color:{{ $meta['color'] }}; font-size:0.7rem;">
                                        {{ $groupSettings->count() }}
                                    </span>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <!-- Quick Info Card -->
                <div class="card border-0 mt-3" style="border-radius:16px; background:linear-gradient(135deg,#4f46e5,#7c3aed); overflow:hidden;">
                    <div class="card-body p-4 text-white">
                        <div class="mb-2"><i class="fas fa-info-circle fa-lg opacity-75"></i></div>
                        <h6 class="fw-bold mb-1">تلميح</h6>
                        <p class="mb-0 opacity-75" style="font-size:0.8rem;">التغييرات تُطبَّق فوراً على الموقع بعد الحفظ. تأكد من مراجعة كل قسم قبل الحفظ.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== Settings Sections ===== -->
        <div class="col-lg-9">
            @foreach($settings as $group => $groupSettings)
                @php
                    $meta = $groupIcons[$group] ?? ['icon' => 'fas fa-sliders-h', 'label' => ucfirst($group), 'color' => '#4f46e5', 'bg' => '#ede9fe'];
                @endphp
                <div class="settings-section-card" id="section-{{ $group }}">
                    <div class="settings-section-header">
                        <div class="section-icon" style="background:{{ $meta['bg'] }}; color:{{ $meta['color'] }};">
                            <i class="{{ $meta['icon'] }}"></i>
                        </div>
                        <div>
                            <h6>{{ $meta['label'] }}</h6>
                            <p>{{ $groupSettings->count() }} إعداد في هذا القسم</p>
                        </div>
                    </div>
                    <div class="settings-section-body">
                        <div class="row g-4">
                            @foreach($groupSettings as $setting)
                                @php
                                    $colClass = in_array($setting->type, ['textarea', 'image']) ? 'col-12' : 'col-md-6';
                                @endphp
                                <div class="{{ $colClass }} setting-field">
                                    @if($setting->type !== 'boolean')
                                        <label class="setting-label">
                                            @if($setting->type === 'image')
                                                <i class="fas fa-image text-primary"></i>
                                            @elseif($setting->type === 'email')
                                                <i class="fas fa-envelope text-info"></i>
                                            @elseif($setting->type === 'url')
                                                <i class="fas fa-link text-success"></i>
                                            @elseif($setting->type === 'color')
                                                <i class="fas fa-palette text-warning"></i>
                                            @elseif($setting->type === 'textarea')
                                                <i class="fas fa-align-left text-secondary"></i>
                                            @else
                                                <i class="fas fa-pen text-muted"></i>
                                            @endif
                                            {{ $setting->label ?? $setting->key }}
                                            @if(str_contains($setting->key, 'ar'))
                                                <span class="label-badge badge" style="background:#fef3c7; color:#d97706;">عربي</span>
                                            @elseif(str_contains($setting->key, 'en'))
                                                <span class="label-badge badge" style="background:#dbeafe; color:#2563eb;">English</span>
                                            @endif
                                        </label>
                                    @endif

                                    {{-- TEXT / EMAIL / URL / NUMBER --}}
                                    @if(in_array($setting->type, ['text', 'email', 'url', 'number']))
                                        <div class="input-group">
                                            @if($setting->type === 'email')
                                                <span class="input-group-text" style="border-radius:10px 0 0 10px; border:1.5px solid #e2e8f0; border-left:none; background:#f8faff;">
                                                    <i class="fas fa-at text-muted"></i>
                                                </span>
                                            @elseif($setting->type === 'url')
                                                <span class="input-group-text" style="border-radius:10px 0 0 10px; border:1.5px solid #e2e8f0; border-left:none; background:#f8faff;">
                                                    <i class="fas fa-globe text-muted"></i>
                                                </span>
                                            @elseif($setting->type === 'number')
                                                <span class="input-group-text" style="border-radius:10px 0 0 10px; border:1.5px solid #e2e8f0; border-left:none; background:#f8faff;">
                                                    <i class="fas fa-hashtag text-muted"></i>
                                                </span>
                                            @endif
                                            <input type="{{ $setting->type }}"
                                                   name="{{ $setting->key }}"
                                                   class="form-control {{ in_array($setting->type, ['email','url','number']) ? '' : '' }}"
                                                   value="{{ $setting->value }}"
                                                   style="{{ in_array($setting->type, ['email','url','number']) ? 'border-radius:0 10px 10px 0;' : '' }}"
                                                   placeholder="{{ $setting->label ?? $setting->key }}">
                                        </div>

                                    {{-- TEXTAREA --}}
                                    @elseif($setting->type === 'textarea')
                                        <textarea name="{{ $setting->key }}"
                                                  class="form-control"
                                                  rows="4"
                                                  maxlength="500"
                                                  oninput="updateCharCount(this)"
                                                  data-counter="counter_{{ $loop->index }}">{{ $setting->value }}</textarea>
                                        <div class="char-counter" id="counter_{{ $loop->index }}">
                                            {{ strlen($setting->value ?? '') }} / 500
                                        </div>

                                    {{-- IMAGE --}}
                                    @elseif($setting->type === 'image')
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md-8">
                                                <div class="image-upload-zone" id="zone_{{ $setting->key }}"
                                                     ondragover="event.preventDefault(); this.style.borderColor='#4f46e5';"
                                                     ondragleave="this.style.borderColor='#cbd5e1';"
                                                     ondrop="handleDrop(event, '{{ $setting->key }}')">
                                                    <input type="file" name="{{ $setting->key }}" accept="image/*"
                                                           onchange="previewSettingImage(this, '{{ $setting->key }}')">
                                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                                    <div class="upload-text">اسحب الصورة هنا أو انقر للاختيار</div>
                                                    <div class="upload-hint">PNG, JPG, SVG — الحد الأقصى 2MB</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="image-preview-box" id="preview_box_{{ $setting->key }}">
                                                    @if($setting->value)
                                                        <img id="preview_{{ $setting->key }}"
                                                             src="{{ asset('storage/' . $setting->value) }}"
                                                             alt="{{ $setting->key }}"
                                                             style="width:100%; max-height:120px; border-radius:10px; border:2px solid #e2e8f0; object-fit:contain; background:#f8faff; padding:6px;">
                                                        <div class="mt-2 text-center">
                                                            <span class="badge" style="background:#d1fae5; color:#059669; font-size:0.7rem;">
                                                                <i class="fas fa-check-circle me-1"></i> صورة محفوظة
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div id="preview_{{ $setting->key }}" class="d-flex align-items-center justify-content-center"
                                                             style="width:100%; height:120px; border-radius:10px; border:2px dashed #e2e8f0; background:#f8faff; color:#cbd5e1; font-size:2rem;">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    {{-- COLOR (type=color OR appearance group with color key) --}}
                                    @elseif($setting->type === 'color' || ($setting->group === 'appearance' && preg_match('/color|_dark|_light|accent/i', $setting->key)))
                                        <div class="color-picker-wrapper">
                                            <input type="color" name="{{ $setting->key }}" value="{{ $setting->value ?? '#4f46e5' }}"
                                                   oninput="document.getElementById('color_text_{{ $loop->index }}').value = this.value; document.getElementById('color_preview_{{ $loop->index }}').style.background = this.value;">
                                            <input type="text" id="color_text_{{ $loop->index }}"
                                                   class="form-control" value="{{ $setting->value ?? '#4f46e5' }}"
                                                   style="font-family: monospace; max-width: 140px;"
                                                   oninput="syncColorPicker(this, '{{ $setting->key }}')"
                                                   placeholder="#000000">
                                            <div class="rounded-circle border" style="width:36px; height:36px; background:{{ $setting->value ?? '#4f46e5' }}; flex-shrink:0;" id="color_preview_{{ $loop->index }}"></div>
                                        </div>

                                    {{-- SELECT / BOOLEAN --}}

                                    @elseif($setting->type === 'select' || $setting->type === 'boolean')
                                        <div class="toggle-setting">
                                            <div class="toggle-info">
                                                <h6>{{ $setting->label ?? $setting->key }}</h6>
                                                @if($setting->description)
                                                    <p>{{ $setting->description }}</p>
                                                @endif
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox"
                                                       name="{{ $setting->key }}"
                                                       value="1"
                                                       {{ $setting->value == 1 ? 'checked' : '' }}
                                                       style="width:48px; height:26px;">
                                            </div>
                                        </div>

                                    {{-- DEFAULT --}}
                                    @else
                                        <input type="text" name="{{ $setting->key }}" class="form-control"
                                               value="{{ $setting->value }}" placeholder="{{ $setting->label ?? $setting->key }}">
                                    @endif

                                    @if($setting->description && $setting->type !== 'boolean' && $setting->type !== 'select')
                                        <div class="setting-hint">
                                            <i class="fas fa-info-circle"></i>
                                            {{ $setting->description }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- ===== Sticky Save Bar ===== -->
            <div class="settings-save-bar">
                <div class="save-card">
                    <div class="save-info">
                        <strong><i class="fas fa-shield-alt me-2"></i>حفظ الإعدادات</strong>
                        التغييرات ستُطبَّق فوراً على الموقع بعد الحفظ
                    </div>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-light px-4" style="border-radius:12px; font-weight:600;">
                            <i class="fas fa-undo me-1"></i> إعادة تعيين
                        </button>
                        <button type="submit" class="btn-save-settings btn">
                            <i class="fas fa-save me-2"></i> حفظ جميع الإعدادات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// ===== Scroll to Section =====
function scrollToSection(group, el) {
    event.preventDefault();
    const section = document.getElementById('section-' + group);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    // Update active nav
    document.querySelectorAll('.settings-nav .nav-link').forEach(l => l.classList.remove('active'));
    el.classList.add('active');
}

// ===== Image Preview for Settings =====
function previewSettingImage(input, key) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const box = document.getElementById('preview_box_' + key);
        box.innerHTML = `
            <img src="${e.target.result}" alt="Preview"
                 style="width:100%; max-height:120px; border-radius:10px; border:2px solid #4f46e5; object-fit:contain; background:#f8faff; padding:6px;">
            <div class="mt-2 text-center">
                <span class="badge" style="background:#ede9fe; color:#4f46e5; font-size:0.7rem;">
                    <i class="fas fa-check-circle me-1"></i> جاهز للرفع
                </span>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

// ===== Drag & Drop =====
function handleDrop(event, key) {
    event.preventDefault();
    const zone = document.getElementById('zone_' + key);
    zone.style.borderColor = '#cbd5e1';
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const input = zone.querySelector('input[type="file"]');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        previewSettingImage(input, key);
    }
}

// ===== Char Counter =====
function updateCharCount(textarea) {
    const counterId = textarea.getAttribute('data-counter');
    const counter = document.getElementById(counterId);
    if (counter) {
        const len = textarea.value.length;
        const max = textarea.getAttribute('maxlength') || 500;
        counter.textContent = `${len} / ${max}`;
        counter.style.color = len > max * 0.9 ? '#ef4444' : '#94a3b8';
    }
}

// ===== Color Sync =====
function syncColorPicker(input, key) {
    const colorInput = document.querySelector(`input[name="${key}"][type="color"]`);
    if (colorInput && /^#[0-9A-Fa-f]{6}$/.test(input.value)) {
        colorInput.value = input.value;
    }
}

// ===== Scroll Spy =====
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('[id^="section-"]');
    const navLinks = document.querySelectorAll('.settings-nav .nav-link');
    let current = '';

    sections.forEach(section => {
        const rect = section.getBoundingClientRect();
        if (rect.top <= 120) {
            current = section.id.replace('section-', '');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-section') === current) {
            link.classList.add('active');
        }
    });
});

// ===== Form Submit Feedback =====
document.getElementById('settingsForm').addEventListener('submit', function() {
    const btn = this.querySelector('.btn-save-settings');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري الحفظ...';
    btn.disabled = true;
});
</script>
@endpush
