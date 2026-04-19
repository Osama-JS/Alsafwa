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
            <div class="accordion-item border-0 mb-2">
                <div class="category-item d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                    <div class="form-check mb-0">
                        <input class="form-check-input filter-category" type="checkbox" name="category[]" value="{{ $category->id }}" id="cat-{{ $category->id }}">
                        <label class="form-check-label small cursor-pointer" for="cat-{{ $category->id }}">{{ $category->{'name_' . app()->getLocale()} }}</label>
                    </div>
                    @if($category->children->count() > 0)
                        <button class="accordion-button collapsed p-0 w-auto bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->id }}"></button>
                    @endif
                </div>
                @if($category->children->count() > 0)
                    <div id="collapse-{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#categoryAccordion">
                        <div class="accordion-body py-1 ps-4 pe-0">
                            @foreach($category->children as $child)
                                <div class="form-check mb-2">
                                    <input class="form-check-input filter-category" type="checkbox" name="category[]" value="{{ $child->id }}" id="cat-{{ $child->id }}">
                                    <label class="form-check-label small cursor-pointer text-muted" for="cat-{{ $child->id }}">{{ $child->{'name_' . app()->getLocale()} }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
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
