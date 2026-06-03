<div class="filter-header d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
    <h5 class="fw-bold mb-0 text-primary-dark">{{ __('الفلاتر') }}</h5>
    <button type="button" onclick="resetFilters()" class="btn btn-link btn-sm text-decoration-none p-0 text-muted">{{ __('إعادة ضبط') }}</button>
</div>

{{-- Search Filter --}}
<div class="filter-group mb-4">
    <label class="filter-label mb-2 fw-bold text-dark">{{ __('بحث باسم المنتج') }}</label>
    <div class="search-input-wrap">
        <input type="text" id="filter-search" class="form-control rounded-pill border-0 shadow-sm ps-4" placeholder="{{ __('ما الذي تبحث عنه؟') }}" value="">
        <i class="fas fa-search search-icon"></i>
    </div>
</div>

{{-- Categories Filter --}}
<div class="filter-group mb-4">
    <label class="filter-label mb-3 fw-bold text-dark">{{ __('الأقسام') }}</label>
    <div class="accordion custom-accordion" id="categoryAccordion">
        @foreach($categories as $category)
            @include('frontend.products._category_item', ['category' => $category, 'parentId' => 'categoryAccordion'])
        @endforeach
    </div>
</div>

{{-- Agencies Filter --}}
<div class="filter-group mb-4">
    <label class="filter-label mb-3 fw-bold text-dark">{{ __('الوكالات') }}</label>
    <div class="agency-list overflow-auto" style="max-height: 250px;">
        @foreach($agencies as $agency)
            <div class="form-check mb-2">
                <input class="form-check-input filter-agency" type="checkbox" name="agency[]" value="{{ $agency->id }}" id="agency-{{ $agency->id }}">
                <label class="form-check-label small cursor-pointer" for="agency-{{ $agency->id }}">{{ $agency->{'name_' . app()->getLocale()} }}</label>
            </div>
        @endforeach
    </div>
</div>
