<li class="mb-2">
    <div class="d-flex align-items-center justify-content-between transition-03 py-1">
        <a href="{{ route('products.index', ['category_id[]' => $category->id, 'navbar' => 1]) }}" 
           class="text-sm text-secondary hover-primary text-decoration-none flex-grow-1">
            <span class="fw-medium">{{ $category->{'name_' . app()->getLocale()} }}</span>
        </a>
        @if($category->allChildren && $category->allChildren->count() > 0)
            <button class="btn btn-sm btn-link text-secondary opacity-50 p-0 ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#megaCat-{{ $category->id }}" aria-expanded="false" onclick="this.querySelector('i').classList.toggle('fa-chevron-down'); this.querySelector('i').classList.toggle('fa-chevron-up');">
                <i class="fas fa-chevron-down" style="font-size: 0.8em;"></i>
            </button>
        @endif
    </div>
    @if($category->allChildren && $category->allChildren->count() > 0)
        <ul class="collapse list-unstyled p-0 m-0 ps-3 mt-1 border-start border-secondary border-opacity-25" id="megaCat-{{ $category->id }}">
            @foreach($category->allChildren as $child)
                @include('frontend.layouts._mega_menu_category', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
