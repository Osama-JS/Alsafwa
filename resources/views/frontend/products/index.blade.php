@extends('frontend.layouts.app')

@section('title', __('المنتجات'))

@push('styles')
<script>
    var filterTimer;
    function fetchProducts(url, isBadgeRemoval) {
        var filterSearch = document.getElementById('filter-search');
        var productsContainer = document.getElementById('products-container');
        var paginationContainer = document.getElementById('pagination-container');
        var resultsCount = document.getElementById('results-count');
        var activeFiltersInner = document.getElementById('active-filters-inner');
        
        if (!productsContainer) return;

        var search = filterSearch ? filterSearch.value : '';
        var categoryIds = [];
        document.querySelectorAll('.filter-category:checked').forEach(function(el) { categoryIds.push(el.value); });
        var agencyIds = [];
        document.querySelectorAll('.filter-agency:checked').forEach(function(el) { agencyIds.push(el.value); });

        productsContainer.classList.add('opacity-50');
        var cfg = document.getElementById('filter-config');
        var baseRoute = cfg ? cfg.dataset.url : window.location.pathname;
        var fetchUrl = url || baseRoute;
        var urlObj = new URL(fetchUrl, window.location.origin);
        
        urlObj.searchParams.delete('search');
        urlObj.searchParams.delete('category_id[]');
        urlObj.searchParams.delete('agency_id[]');
        
        if (search) urlObj.searchParams.set('search', search);
        categoryIds.forEach(function(id) { urlObj.searchParams.append('category_id[]', id); });
        agencyIds.forEach(function(id) { urlObj.searchParams.append('agency_id[]', id); });

        fetch(urlObj.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            productsContainer.innerHTML = data.html;
            productsContainer.classList.remove('opacity-50');
            if (paginationContainer) paginationContainer.innerHTML = data.pagination;
            if (resultsCount) resultsCount.textContent = data.total;
            
            if (activeFiltersInner) {
                renderActiveBadges(categoryIds, agencyIds, search);
            }

            window.history.pushState({}, '', urlObj.toString());
            if (typeof AOS !== 'undefined') AOS.refresh();
            
            if (window.innerWidth < 992 && !isBadgeRemoval && !url) {
                var filterOffcanvas = document.getElementById('filterSidebar');
                if (filterOffcanvas && filterOffcanvas.classList.contains('show')) {
                    var bsOffcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                    if (bsOffcanvas) bsOffcanvas.hide();
                }
            }
        })
        .catch(function(err) {
            console.error('AJAX Error:', err);
            if (productsContainer) productsContainer.classList.remove('opacity-50');
        });
    }

    function renderActiveBadges(catIds, agIds, search) {
        var container = document.getElementById('active-filters-inner');
        if (!container) return;
        container.innerHTML = '';
        var hasFilters = false;

        catIds.forEach(function(id) {
            var label = document.querySelector('label[for="cat-'+id+'"]');
            if (label) {
                addBadge(container, label.textContent, 'cat-'+id);
                hasFilters = true;
            }
        });

        agIds.forEach(function(id) {
            var label = document.querySelector('label[for="agency-'+id+'"]');
            if (label) {
                addBadge(container, label.textContent, 'agency-'+id);
                hasFilters = true;
            }
        });

        if (search) {
            addBadge(container, "{{ __('بحث:') }} " + search, 'search-reset');
            hasFilters = true;
        }

        var wrap = document.getElementById('active-filters-wrap');
        if (wrap) wrap.style.display = hasFilters ? 'block' : 'none';
    }

    function addBadge(container, text, id) {
        var badge = document.createElement('span');
        badge.className = 'active-filter-badge';
        badge.innerHTML = text + ' <i class="fas fa-times ms-2 cursor-pointer" onclick="removeFilter(\''+id+'\')"></i>';
        container.appendChild(badge);
    }

    function removeFilter(id) {
        if (id === 'search-reset') {
            var inp = document.getElementById('filter-search');
            if (inp) inp.value = '';
        } else {
            var chk = document.getElementById(id);
            if (chk) chk.checked = false;
        }
        fetchProducts(null, true);
    }

    function handleFilters() {
        clearTimeout(filterTimer);
        filterTimer = setTimeout(function() { fetchProducts(); }, 400);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var filterSearch = document.getElementById('filter-search');
        var urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('navbar')) {
            syncFiltersWithUrl(urlParams);
            urlParams.delete('navbar');
            window.history.replaceState({}, '', window.location.pathname + '?' + urlParams.toString());
        } else {
            if (filterSearch) filterSearch.value = '';
            document.querySelectorAll('.filter-category, .filter-agency').forEach(function(el) { el.checked = false; });
            var cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({path: cleanUrl}, '', cleanUrl);
        }

        if (filterSearch) filterSearch.addEventListener('input', handleFilters);
        document.querySelectorAll('.filter-category, .filter-agency').forEach(function(element) {
            element.addEventListener('change', handleFilters);
        });
        document.addEventListener('click', function(e) {
            var link = e.target.closest('#pagination-container a');
            if (link) {
                e.preventDefault();
                fetchProducts(link.href);
                window.scrollTo({ top: 300, behavior: 'smooth' });
            }
        });
        window.resetFilters = function() {
            if (filterSearch) filterSearch.value = '';
            document.querySelectorAll('.filter-category, .filter-agency').forEach(function(el) { el.checked = false; });
            fetchProducts();
        };

        function syncFiltersWithUrl(params) {
            params.getAll('category_id[]').forEach(function(id) {
                var el = document.getElementById('cat-' + id);
                if (el) el.checked = true;
            });
            params.getAll('agency_id[]').forEach(function(id) {
                var el = document.getElementById('agency-' + id);
                if (el) el.checked = true;
            });
            if (params.has('search') && filterSearch) filterSearch.value = params.get('search');
            fetchProducts();
        }
    });
</script>
<style>
    .filter-sidebar { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 1.5rem; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .filter-label { font-size: 0.9rem; letter-spacing: 0.5px; text-transform: uppercase; color: var(--primary-dark); opacity: 0.8; }
    .search-input-wrap { position: relative; }
    .search-input-wrap .form-control { background: #f8fafc; height: 45px; transition: all 0.3s ease; }
    .search-input-wrap .form-control:focus { background: #fff; box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1); }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    [dir="rtl"] .search-icon { left: auto; right: 15px; }
    [dir="rtl"] .search-input-wrap .form-control { padding-right: 45px !important; padding-left: 15px !important; }
    .agency-list::-webkit-scrollbar { width: 5px; }
    .agency-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    #pagination-container .pagination { gap: 8px; }
    #pagination-container .page-item .page-link { border: none; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50% !important; color: var(--primary-dark); font-weight: 600; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(5px); box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: 0.3s; }
    #pagination-container .page-item.active .page-link { background: var(--primary); color: #fff; transform: scale(1.1); }
    .active-filter-badge { display: inline-flex; align-items: center; background: #f0f4f8; border: 1px solid #e2e8f0; padding: 4px 12px; border-radius: 100px; font-size: 0.8rem; color: var(--primary-dark); margin-right: 8px; margin-bottom: 8px; transition: 0.2s; }
    .active-filter-badge:hover { background: #e2e8f0; }
    .filter-mobile-toggle { display: none; }
    @media (max-width: 991.98px) {
        .filter-sidebar-wrap { display: none; }
        .filter-mobile-toggle { display: flex; }
        .filter-sidebar { background: #fff; border:none; box-shadow: none; padding: 1.5rem; }
    }
</style>
@endpush

@section('content')
<div id="filter-config" data-url="{{ route('products.index') }}" style="display:none;"></div>
<section class="inner-page-hero">
    <div class="inner-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80')"></div>
    <div class="inner-hero-overlay"></div>
    <div class="container position-relative" style="z-index: 2; padding-top:80px">
        <div class="inner-hero-content">
            <span class="section-suptitle text-white opacity-75">{{ __('تسوّق الآن') }}</span>
            <h1 class="inner-title">{{ __('المنتجات') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('المنتجات') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<section class="section-legendary">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 filter-sidebar-wrap">
                <div class="filter-sidebar" data-aos="fade-right">
                    @include('frontend.products._sidebar_content')
                </div>
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filterSidebar">
                <div class="offcanvas-header bg-light border-bottom">
                    <h5 class="offcanvas-title fw-bold">{{ __('البحث والتصفية') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="filter-sidebar">
                        @include('frontend.products._sidebar_content')
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="results-toolbar mb-4 bg-white p-3 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-primary filter-mobile-toggle rounded-pill px-4 py-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                                <i class="fas fa-sliders-h me-2"></i> {{ __('الفئات') }}
                            </button>
                            <div class="text-muted small">{{ __('عرض') }} <span id="results-count" class="fw-bold text-dark">{{ $products->total() }}</span> {{ __('منتج متوفر') }}</div>
                        </div>
                    </div>
                    <div id="active-filters-wrap" class="mt-3 pt-3 border-top" style="display:none;">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="text-xs text-secondary me-3 mb-2">{{ __('الفلاتر النشطة:') }}</span>
                            <div id="active-filters-inner" class="d-flex flex-wrap"></div>
                        </div>
                    </div>
                </div>
                <div id="products-container" class="row g-4 position-relative">
                    @include('frontend.products._list')
                </div>
                <div id="pagination-container" class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
