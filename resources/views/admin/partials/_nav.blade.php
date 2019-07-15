<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container" style="margin-bottom: 0;">
        <!-- Mobile header -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-menu" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin/dashboard') }}">{{ settings('site_name') }}</a>
        </div>

        <!-- Desktop header -->
        <div class="collapse navbar-collapse" id="navigation-menu">
            <ul class="nav navbar-nav">
                @foreach (AdminHelper::getNavigation() as $name => $nav)
                    @if (!empty($nav['url']))
                        <li class="{{ ($nav['active'] ? 'active' : '') }}">
                            <a href="{{ $nav['url'] }}">{{ $name }}</a>
                        </li>
                    @else
                        <li class="dropdown {{ ($nav['active'] ? 'active' : '') }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ $name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach ($nav['items'] as $name => $nav)
                                    <li><a href="{{ $nav }}">{{ $name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li data-toggle="tooltip" data-placement="bottom" title="Go to Site">
                    <a href="{{ url('/') }}" target="_blank"><span class="glyphicon glyphicon-new-window" style="font-size: 16px; vertical-align: middle;"></span></a>
                </li>
                <li class="{{ request()->is('admin/redirects*') ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Redirects">
                    <a href="{{ route('admin.redirects.index') }}"><span class="glyphicon glyphicon-random" style="font-size: 16px; vertical-align: middle;"></span></a>
                </li>
                <li class="{{ request()->is('admin/settings*') ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Settings">
                    <a href="{{ route('admin.settings.index') }}"><span class="glyphicon glyphicon-cog" style="font-size: 16px; vertical-align: middle;"></span></a>
                </li>
                <li data-toggle="tooltip" data-placement="bottom" title="Logout">
                    <a href="{{ url('/admin/logout') }}"><span class="glyphicon glyphicon-off" style="font-size: 16px; vertical-align: middle;"></span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
