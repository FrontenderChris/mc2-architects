@extends('layouts.app')

@section('content')
<div class="row dashboard">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <div class="chart-wrapper">
                    <div class="col-xs-12 header-col">
                        <div class="col-xs-6">
                            <h3>Website Statistics <small>{{ $hostName }}</small></h3>
                        </div>
                        <div class="col-xs-6 text-right">
                            @if ($request->has('weekly'))
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">Show Monthly</a>
                            @else
                                <a href="{{ route('dashboard', ['weekly' => 1]) }}" class="btn btn-primary">Show Weekly</a>
                            @endif
                        </div>
                    </div>

                    <canvas id="pageViewsChart"></canvas>
                </div>

                <div class="col-xs-12 text-center">
                    <h4><strong>{{ $startDate->format('d F') }} to {{ $endDate->format('d F') }}</strong></h4>
                </div>

                <div class="chart-row">
                    <div class="item">
                        <div class="small-circle">
                            <canvas id="trafficSourceChart"></canvas>
                        </div>
                        <p>Traffic Sources (visits)</p>
                    </div>
                    <div class="item">


                        <p>New Visitors</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" style="background-color: #15a2fc; width:{{ $data['newReturningVisitors']['new-percentage'] }}%">
                                {{ $data['newReturningVisitors']['new'] }} visits
                            </div>
                        </div>
                        <br>
                        <p>Returning Visitors</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" style="background-color: #15a2fc; width:{{ $data['newReturningVisitors']['returning-percentage'] }}%">
                                {{ $data['newReturningVisitors']['returning'] }} visits
                            </div>
                        </div>



                    </div>
                    <div class="item">
                        <div class="small-circle">
                            <canvas id="devicesChart"></canvas>
                        </div>
                        <p>Devices (visits)</p>
                    </div>
                </div>
                <hr>
                <div class="chart-row">
                    <div class="item">
                        <p>Top Referrers (visits)</p>
                        <ol>
                            @foreach ($data['topReferrers'] as $row)
                                <li>{{ ($row['url'] == '(direct)' ? 'Direct' : $row['url']) }} ({{ $row['pageViews'] }})</li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="item">
                        <p>Bounce Rate</p>
                        <div class="small-circle circliful-circle">
                            <div class="do-circliful" data-percent="{{ (!empty($data['bounceRate']['rows'][0][0]) ? $data['bounceRate']['rows'][0][0] : 0) }}"></div>
                        </div>
                    </div>
                    <div class="item">
                        <p>Most Visited Pages (visits)</p>
                        <ol>
                            @foreach ($data['mostVisitedPages'] as $row)
                                <li>{{ ($row['url'] == '/' ? 'Homepage' : $row['url']) }} ({{ $row['pageViews'] }})</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    makeViewsChart(
        {!! json_encode($data['pageViewsVisitors']['labels']) !!},
        {!! json_encode($data['pageViewsVisitors']['visitors']) !!},
        {!! json_encode($data['pageViewsVisitors']['pageViews']) !!}
    );

    makeTrafficSourceChart(
        {{ $data['trafficSources']['direct'] }},
        {{ $data['trafficSources']['organic'] }},
        {{ $data['trafficSources']['referral'] }}
    );

    makeDevicesChart(
        {{ $data['deviceCategories']['desktop'] }},
        {{ $data['deviceCategories']['mobile'] }},
        {{ $data['deviceCategories']['tablet'] }}
    );
</script>
@endsection