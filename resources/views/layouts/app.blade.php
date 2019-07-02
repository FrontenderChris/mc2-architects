<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-navbutton-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon" />

    @if (!empty($seo))
        <meta name="keywords" content="{{ $seo->keywords }}">
        <meta name="description" content="{{ $seo->description }}">
        <meta property="og:site_name" content="{{ $seo->title }}"/>
        <meta property="og:title" content="{{ $seo->og_title }}"/>
        <meta property="og:description" content="{{ $seo->og_description }}"/>
        @if ($seo->image)
            <meta property="og:image" content="{{ $seo->image->getSrc(true) }}"/>
        @endif
    @endif
    <title>{{ (!empty($seo) && !empty($seo->title) ? $seo->title : settings('site_name')) }}</title>

    <script>
        var App = {};
        App.imageSrc = '{{ ViewHelper::getImgSrc() }}';
        App.currentUrl = '{{ Request::url() }}';
        App.baseUrl = '{{ url('/') }}';
    </script>

    <!-- Styles -->
    <link href="{{ ViewHelper::getCssSrc('styles.css') }}" rel="stylesheet">

    <script src="https://use.typekit.net/phh5jxc.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <!--[if lt IE 10]>
    <script src="/js/lib/respond.js"></script>
    <![endif]-->

	@if ($code = settings('ga_code'))
    	{!! $code !!}
    @endif

    <script src="https://kit.fontawesome.com/d872039177.js"></script>

    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-5BWN734');</script>
	<!-- End Google Tag Manager -->
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BWN734"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
    
    @include('layouts.partials.header')
    @yield('content')
    @include('layouts.partials.footer')
    @yield('footer')

    
	<!-- the js files that are compiled -->
    <!--<script src="{{ ViewHelper::getJsSrc('plugins.js') }}"></script>-->
    <script src="{{ ViewHelper::getJsSrc('site.js') }}"></script>

    @stack('scripts')

</body>
</html>
