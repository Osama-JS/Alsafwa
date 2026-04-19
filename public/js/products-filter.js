var filterTimer;

function fetchProducts(url) {
    var filterSearch = document.getElementById('filter-search');
    var productsContainer = document.getElementById('products-container');
    var paginationContainer = document.getElementById('pagination-container');
    var resultsCount = document.getElementById('results-count');

    var search = filterSearch ? filterSearch.value : '';
    var categoryIds = [];
    document.querySelectorAll('.filter-category:checked').forEach(function(el) {
        categoryIds.push(el.value);
    });
    var agencyIds = [];
    document.querySelectorAll('.filter-agency:checked').forEach(function(el) {
        agencyIds.push(el.value);
    });

    if (productsContainer) productsContainer.classList.add('opacity-50');
    
    // Get base URL from global variable defined in footer/head
    var baseRoute = window.productsIndexUrl || window.location.pathname;
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
        if (productsContainer) {
            productsContainer.innerHTML = data.html;
            productsContainer.classList.remove('opacity-50');
        }
        if (paginationContainer) paginationContainer.innerHTML = data.pagination;
        if (resultsCount) resultsCount.textContent = data.total;
        window.history.pushState({}, '', urlObj.toString());
        if (typeof AOS !== 'undefined') AOS.refresh();
    })
    .catch(function(err) {
        console.error('Filtering Error:', err);
        if (productsContainer) productsContainer.classList.remove('opacity-50');
    });
}

function handleFilters() {
    clearTimeout(filterTimer);
    filterTimer = setTimeout(function() { fetchProducts(); }, 400);
}

document.addEventListener('DOMContentLoaded', function() {
    var filterSearch = document.getElementById('filter-search');

    // Reset on load as requested
    if (filterSearch) filterSearch.value = '';
    document.querySelectorAll('.filter-category, .filter-agency').forEach(function(el) { el.checked = false; });
    var cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.replaceState({path: cleanUrl}, '', cleanUrl);

    if (filterSearch) {
        filterSearch.addEventListener('input', handleFilters);
    }

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
});
