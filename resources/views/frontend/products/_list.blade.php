@forelse($products as $product)
    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 12) * 50 }}">
        <div class="product-card-v3">
            <a href="{{ route('products.show', $product->slug) }}" class="product-img-wrap text-decoration-none">
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
            </a>

            <div class="product-body">
                <div class="product-meta-tags">
                    @if($product->agency)
                        <a href="{{ route('agencies.show', $product->agency->slug) }}" class="product-badge-agency">
                            <i class="fas fa-building me-1 opacity-75"></i> {{ $product->agency->{'name_' . app()->getLocale()} }}
                        </a>
                    @endif

                    @if($product->productCategory)
                        <a href="{{ route('products.index', ['category_id' => $product->productCategory->id]) }}" class="product-badge-category">
                            <i class="fas fa-tag me-1 opacity-75"></i> {{ $product->productCategory->{'name_' . app()->getLocale()} }}
                        </a>
                    @endif
                </div>

                <h3 class="product-title">
                    <a href="{{ route('products.show', $product->slug) }}">
                        {{ $product->{'title_' . app()->getLocale()} }}
                    </a>
                </h3>

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

                <div class="product-card-actions">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn-order-now">
                        <span>{{ __('اطلب الآن') }}</span>
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    @php
                        $waNum = preg_replace('/[^0-9]/', '', setting('whatsapp_number', ''));
                        $waText = urlencode(__('مرحباً، أود الاستفسار عن: ') . $product->{'title_' . app()->getLocale()});
                    @endphp
                    <a href="{{ $waNum ? 'https://wa.me/' . $waNum . '?text=' . $waText : 'https://wa.me/' . setting('whatsapp_number') }}" target="_blank" class="btn-whatsapp-card" title="{{ __('استفسر عبر الواتساب') }}">
                        <i class="fab fa-whatsapp fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
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
