<li class="mb-1">
    <a href="{{ route('products.index', ['category_id[]' => $category->id, 'navbar' => 1]) }}" class="text-xs text-secondary opacity-75 hover-primary text-decoration-none transition-03 d-block py-1">
        - {{ $category->{'name_' . app()->getLocale()} }}
    </a>
    @if($category->allChildren && $category->allChildren->count() > 0)
        <ul class="list-unstyled p-0 m-0 ps-3 ms-1 border-start border-light border-opacity-10">
            @foreach($category->allChildren as $child)
                @include('frontend.layouts._mega_menu_category', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
