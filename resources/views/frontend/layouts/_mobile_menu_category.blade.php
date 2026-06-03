<div class="mb-1">
    <a href="{{ route('products.index', ['category_id[]' => $category->id, 'navbar' => 1]) }}" class="py-1 text-xs opacity-75 d-block text-decoration-none">
        - {{ $category->{'name_' . app()->getLocale()} }}
    </a>
    @if($category->allChildren && $category->allChildren->count() > 0)
        <div class="ps-3 border-start ms-2">
            @foreach($category->allChildren as $child)
                @include('frontend.layouts._mobile_menu_category', ['category' => $child])
            @endforeach
        </div>
    @endif
</div>
