@extends('layouts.app')

@section('content')
	<main role="main" class="main page-contact">

        <section class="hero-container" style="background-image: url({{ getImage($page, '/images/hero3.jpg', null) }});">
            <div class="before">

                <div class="center">
                    <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                    <p>CONTACT US</p>
                </div>

                <a class="js-scroll-down scroller">
                    <img src="/images/black-arrow.png">
                </a>

            </div>

			<a class="js-scroll-down scroller">
				<img src="/images/black-arrow.png">
			</a>
		</section>

		<section class="title-container">
            <div class="content-narrow-width">

                <h1>{{ $page->title }}</h1>
                <h2>{{ $page->data['lead_copy'] }}</h2>

            </div>
        </section>
		<section class="contact-container">
			<div class="content-narrow-width">
				<div class="col1">
					<a href="tel:{{ $page->data['phone'] }}" class="phone">{{ $page->data['phone'] }}</a>
					<a href="mailto:{{ $page->data['email'] }}" class="email">{{ $page->data['email'] }}</a>

					<p class="address">{!! nl2br($page->data['physical_address']) !!}</p>
					<p class="address">{!! nl2br($page->data['postal_address']) !!}</p>
				</div>
				<div class="col2 map-area">
                    <div class="map" id="map-auckland"></div>
				</div>

                @include('modules._contact-form')

            </div>
		</section>

	</main>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('MAPS_API_KEY') }}"></script>
    <script type="text/javascript">

        $('.before .center').addClass('on');

        setTimeout(function() {
            $('.hero-container').addClass('loaded');
        }, 800);

        setTimeout(function() {
            $('.js-scroll-down').trigger('click');
        }, 2200);


        $(document).ready(function(){
            initGmap(
                'auckland',
            @if(!empty($page->data['lat']) && !empty($page->data['lng']))
            {{$page->data['lat']}},
            {{$page->data['lng']}}
                    @else
                -36.9516433,
                174.9010839
            @endif
        );

            $('.do-activate-map').click(function(){
                var that = $(this);
                initGmap(that.data('slug'), that.data('lat'), that.data('lng'));
            });
        });

        function initGmap(selector, lat, lng)
        {
            var id = 'map-' + selector;
            var curpoint = new google.maps.LatLng(lat, lng);
            var gmapdata = new google.maps.Map(document.getElementById(id), {
                center: curpoint,
                zoom: 16,
                mapTypeId: 'roadmap'
            });

            var gmapmarker = new google.maps.Marker({
                map: gmapdata,
                // icon: '/images/marker.png',
                position: curpoint
            });
        }
    </script>
@endpush