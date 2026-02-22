@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => null])

<div class="stat-card">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="stat-label mb-1">{{ $title }}</div>
            <div class="stat-value">{{ $value }}</div>
        </div>
        <div class="stat-icon bg-{{ $color }} bg-opacity-10 text-{{ $color }}">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    @if($link)
        <div class="mt-3">
            <a href="{{ $link }}" class="text-xs font-medium text-{{ $color }} text-decoration-none">
                عرض التفاصيل <i class="fas fa-arrow-left ms-1"></i>
            </a>
        </div>
    @endif
</div>
