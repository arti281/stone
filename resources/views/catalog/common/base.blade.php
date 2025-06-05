<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="google-site-verification" content="bWM-VcqRmXRp-zkHn67X9F0y8A3WhVbcA1LBz3eoawk" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ URL::asset('pstone-logo.png'); }}" type="image/png">
    <link rel="icon" href="{{ URL::asset('pstone-logo.ico'); }}" type="image/x-icon">
    <title>@stack('setTitle')</title>
    <meta name="description" content="@stack('setDescription')">
    <meta name="keywords" content="@stack('setKeyword')">
    <meta name="author" content="@if (app('settings') && isset(app('settings')['site_title'])){{ app('settings')['site_title'] }} @endif">

    <!-- Additional Meta Tags -->
    <meta name="robots" content="index, follow"> <!-- or "noindex, nofollow" -->
    <link rel="canonical" href="@stack('setCanonicalURL')"> <!-- Canonical URL -->

    <link rel="stylesheet" href="{{ URL::asset('css/catalog/common/common.css'); }}">
    <link rel="stylesheet" href="{{ URL::asset('css/catalog/style.css'); }}">

    <!-- Add additional css link -->
    @stack('addStyle')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- select 2 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

</head>
<body style="background:#f4f4f4;overflow-x:hidden">
    @include('catalog.common.top_header')
    @include('catalog.common.header')
    @yield('content')
    @include('catalog.common.footer')

     <!-- Add additional js link -->
     @stack('addScript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    
    <script>
        // for tooltip
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
 </script>
</body>
</html>