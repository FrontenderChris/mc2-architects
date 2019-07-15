@extends('layouts.app')

@section('content')
    <div class="row dashboard">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="col-md-12">
                    <br>
                    <img src="{{ \App\Helpers\AdminHelper::getImgSrc('dashboard-demo.jpg') }}" alt="dashboard demo" />

                    @if (AdminHelper::isSuperAdmin())
                        <br>
                        <p>To install the google dashboard:</p>
                        <ol>
                            <li>Add your Google Analytics Site ID to the laravel-analytics config file. Find your site ID in Google Analytics > Admin > View Settings > View ID. Enter the value as <strong>ga:xxxxxxxx</strong>.</li>
                            <li>Add the specified email address to the Google Analytics > User Management list. <strong>728425166170-compute@developer.gserviceaccount.com</strong></li>
                            <li>That's it!</li>
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection