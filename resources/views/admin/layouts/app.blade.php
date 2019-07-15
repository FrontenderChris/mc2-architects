<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Used to validate AJAX requests with CSRF protection -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Back Office</title>

    <script>
        var App = {};
        App.post_max_size = {{ AdminHelper::getPostMaxSize() }};
        App.upload_max_filesize = {{ AdminHelper::getUploadMaxFilesize() }};
        App.csrf_token = '{{ csrf_token() }}';
    </script>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ AdminHelper::getCssSrc('application.css') }}">
</head>
<body id="app-layout" class="{{ request()->path() != 'admin/dashboard' ? 'fouc' : '' }}">

    <div class="app app-header-fixed">
        @include('partials._nav')
        <div class="container">
            @yield('content')
        </div>
    </div>

    <script src="{{ AdminHelper::getJsSrc('application.js') }}"></script>
    @yield('footer')
</body>
</html>
