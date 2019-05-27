<header id="site-header" class="site-header">
    <ul class="lang-btn">
        @foreach (Config::get('app.locales') as $lang => $language)
            @if ($lang != App::getLocale())
                <li><a href="{{ route('lang.change', $lang) }}">{{$language}}</a></li>
            @endif
        @endforeach
    </ul>
    <button onclick="slideMenu()" class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </button>

</header>
<!--   End: Header    -->

@include('layouts.partials.mobile-menu')