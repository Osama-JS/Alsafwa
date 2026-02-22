@props(['action', 'expanded' => false])

<div class="filter-card">
    <div class="d-flex justify-content-between align-items-center mb-3 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="{{ $expanded ? 'true' : 'false' }}">
        <h5 class="m-0 fs-6 fw-bold text-secondary"><i class="fas fa-filter me-2"></i> تصفية وبحث متقدم</h5>
        <i class="fas fa-chevron-down text-muted transition-icon"></i>
    </div>

    <div class="collapse {{ $expanded ? 'show' : '' }}" id="filterCollapse">
        <form action="{{ $action }}" method="GET">
            <div class="row g-3">
                {{ $slot }}

                <div class="col-12 mt-4 d-flex justify-content-end border-top pt-3">
                    <a href="{{ $action }}" class="btn btn-light btn-custom me-2" type="button">
                        <i class="fas fa-undo me-1"></i> إعادة تعيين
                    </a>
                    <button type="submit" class="btn btn-primary-custom btn-custom">
                        <i class="fas fa-search me-1"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-icon { transition: transform 0.3s; }
    [aria-expanded="true"] .transition-icon { transform: rotate(180deg); }
</style>
