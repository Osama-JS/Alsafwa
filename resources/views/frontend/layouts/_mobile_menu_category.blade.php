<div class="mb-2">
    <div class="d-flex align-items-center justify-content-between py-2 transition-03">
        <a href="{{ route('products.index', ['category_id[]' => $category->id, 'navbar' => 1]) }}" 
           class="text-sm text-white opacity-75 hover-primary text-decoration-none flex-grow-1">
            <span class="fw-medium">{{ $category->{'name_' . app()->getLocale()} }}</span>
        </a>
        @if($category->allChildren && $category->allChildren->count() > 0)
            <button class="btn btn-sm btn-link text-white opacity-50 p-0 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCat-{{ $category->id }}" aria-expanded="false" onclick="this.querySelector('i').classList.toggle('fa-chevron-down'); this.querySelector('i').classList.toggle('fa-chevron-up');">
                <i class="fas fa-chevron-down" style="font-size: 0.8em;"></i>
            </button>
        @endif
    </div>
    @if($category->allChildren && $category->allChildren->count() > 0)
        <div class="collapse ps-3 border-start border-light border-opacity-25 mt-1 ms-2" id="mobileCat-{{ $category->id }}">
            @foreach($category->allChildren as $child)
                @include('frontend.layouts._mobile_menu_category', ['category' => $child])
            @endforeach
        </div>
    @endif
</div>
