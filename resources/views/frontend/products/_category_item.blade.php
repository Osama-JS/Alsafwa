<div class="accordion-item border-0 mb-2">
    <div class="category-item d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
        <div class="form-check mb-0">
            <input class="form-check-input filter-category" type="checkbox" name="category[]" value="{{ $category->id }}" id="cat-{{ $category->id }}">
            <label class="form-check-label small cursor-pointer" for="cat-{{ $category->id }}">{{ $category->{'name_' . app()->getLocale()} }}</label>
        </div>
        @if($category->allChildren->count() > 0)
            <button class="accordion-button collapsed p-0 w-auto bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $category->id }}"></button>
        @endif
    </div>
    @if($category->allChildren->count() > 0)
        <div id="collapse-{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#{{ $parentId ?? 'categoryAccordion' }}">
            <div class="accordion-body py-1 ps-4 pe-0">
                <div class="accordion custom-accordion" id="accordion-{{ $category->id }}">
                    @foreach($category->allChildren as $child)
                        @include('frontend.products._category_item', ['category' => $child, 'parentId' => 'accordion-'.$category->id])
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
