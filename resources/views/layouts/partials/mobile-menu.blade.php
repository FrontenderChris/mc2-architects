    <!--   Start: Header > Small Screen Main Menu   -->
    <nav id="mobile-menu" status="closed">

        <div class="menu-content">

            <div class="center">
                <a href="/" class="logo">
                    <img src="/images/logo-black.svg">
                </a>

                <ul>
                    <?php  $route = Route::current();?>
                   
                    <li class="{{ ($route->page) == '' && $route->uri() == '/' ? 'active' : '' }}"><a href="/">@lang('menu.home')</a></li>
                    <li class="{{ ($route->page) == 'about-us' ? 'active' : '' }}"><a href="/about-us">@lang('menu.aboutUs')</a></li>
                    <li class="{{ ($route->page) == 'profile' ? 'active' : '' }}"><a href="/profile">@lang('menu.profile')</a></li>
                    <li class="{{ ($route->uri()) == 'projects' ? 'active' : '' }}"><a href="/projects">@lang('menu.projects')</a></li>
                    <li class="{{ ($route->page) == 'contact-us' ? 'active' : '' }}"><a href="/contact-us">@lang('menu.contactUs')</a></li>
                </ul>
            </div>
        </div>     
    </nav>
    <!--   End: Header > Small Screen Main Menu   -->