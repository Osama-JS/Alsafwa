@forelse($products as $product)
    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 12) * 50 }}">
        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none d-block h-100">
            <div class="product-card-v3">
                <div class="product-img-wrap">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->{'title_' . app()->getLocale()} }}">
                    @else
                        <div class="product-img-placeholder">
                            <i class="fas fa-box fs-1 opacity-25"></i>
                        </div>
                    @endif

                    @if($product->discount && $product->price)
                        <span class="product-badge-sale">{{ __('خصم') }}</span>
                    @endif

                    @if($product->agency)
                        <span class="product-badge-agency">{{ $product->agency->{'name_' . app()->getLocale()} }}</span>
                    @endif

                    @if($product->productCategory)
                        <span class="product-badge-category">
                            <i class="fas fa-tag me-1"></i> 
                            @if($product->productCategory->parent)
                                {{ $product->productCategory->parent->{'name_' . app()->getLocale()} }} <i class="fas fa-chevron-left mx-1 small opacity-50"></i>
                            @endif
                            {{ $product->productCategory->{'name_' . app()->getLocale()} }}
                        </span>
                    @endif
                </div>

                <div class="product-body">
                    <h3 class="product-title">{{ $product->{'title_' . app()->getLocale()} }}</h3>

                    @if($product->{'description_' . app()->getLocale()})
                        <p class="product-desc">{{ Str::limit($product->{'description_' . app()->getLocale()}, 80) }}</p>
                    @endif

                    @if($product->price)
                        <div class="product-price-wrap">
                            @if($product->discount)
                                <span class="product-price-old">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                                <span class="product-price-current">{{ number_format($product->final_price, 2) }} {{ __('ر.س') }}</span>
                            @else
                                <span class="product-price-current">{{ number_format($product->price, 2) }} {{ __('ر.س') }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12 py-5 text-center my-5">
        <div class="empty-state-icon mb-4">
            <i class="fas fa-search fs-1 text-muted opacity-25"></i>
        </div>
        <h4 class="fw-bold mb-2">{{ __('لا توجد نتائج تطابق فلترة البحث') }}</h4>
        <p class="text-muted">{{ __('جرب استخدام كلمات بحث أخرى أو تغيير الفلاتر المختارة') }}</p>
        <button type="button" onclick="resetFilters()" class="btn btn-primary-custom mt-3 rounded-pill px-4">
            {{ __('إعادة ضبط الفلاتر') }}
        </button>
    </div>
@endforelse
