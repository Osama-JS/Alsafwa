@php
    $siteName = setting('company_name_' . app()->getLocale(), 'AlSafua');
    $title = View::hasSection('title') ? View::getSection('title') . ' - ' . $siteName : $siteName;
    $description = View::hasSection('meta_description') ? View::getSection('meta_description') : setting('seo_meta_description_' . app()->getLocale());
    $image = View::hasSection('meta_image') ? View::getSection('meta_image') : asset('storage/' . setting('company_logo'));
    $url = url()->current();
@endphp

<!-- Primary Meta Tags -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $url }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">

<!-- Canonical -->
<link rel="canonical" href="{{ $url }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('storage/' . setting('company_favicon')) }}">
