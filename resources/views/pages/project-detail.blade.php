@extends('layouts.app')

@section('content')
	<main role="main" class="main page-project-detail">

		<section class="hero-container" style="background-image: url({{ ($image_banner = $model->image('banner')) ? $image_banner->getSrc() : 'http://placehold.it/500x500' }});">

			<div class="before">

                <div class="center">
                    <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                    <p>{{$model->title}}</p>
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
            <div class="content-max-width">

                <h1>{{$model->title}}</h1>
                <h2>{{$model->data['location']}}</h2>

            </div>
		</section>
		<section class="project-container clear-after">
			<div class="content-max-width img-container">
				
				@if($model->image('hero'))
				<div class="image {{ !empty($model->data['hero1_is_full']) && ($model->data['hero1_is_full'] == true) ? 'full' : 'half' }}">
                    <img src="{{ $model->image('hero')->getSrc() }}" 
						alt="MC2 Architects slideshow 1"
						data-src="{{ $model->image('hero')->getSrc() }}"
						href="{{ $model->image('hero')->getSrc() }}"
						data-index="0"
					>
				</div>
				@endif
				
				@if($model->image('hero2'))
				<div class="image {{ !empty($model->data['hero2_is_full']) && ($model->data['hero2_is_full'] == true) ? 'full' : 'half' }}">
                    <img src="{{ $model->image('hero2')->getSrc() }}"
						alt="MC2 Architects slideshow 2"
						data-src="{{ $model->image('hero2')->getSrc() }}"
						href="{{ $model->image('hero2')->getSrc() }}"
						data-index="1"
					>
				</div>
				@endif
				
				@if($model->image('hero3'))
				<div class="image {{ !empty($model->data['hero3_is_full']) && ($model->data['hero3_is_full'] == true) ? 'full' : 'half' }}">
                    <img src="{{ $model->image('hero3')->getSrc() }}"
						alt="MC2 Architects slideshow 3"
						data-src="{{ $model->image('hero3')->getSrc() }}"
						href="{{ $model->image('hero3')->getSrc() }}"
						data-index="2"
					>
				</div>
				@endif

				@if($model->image('hero4'))
				<div class="image {{ !empty($model->data['hero4_is_full']) && ($model->data['hero4_is_full'] == true) ? 'full' : 'half' }}">
					<img src="{{ $model->image('hero4')->getSrc() }}"
						alt="MC2 Architects slideshow 4"
						data-src="{{ $model->image('hero4')->getSrc() }}"
						href="{{ $model->image('hero4')->getSrc() }}"
						data-index="3"
					>
				</div>
				@endif

				@if($model->image('hero5'))
				<div class="image {{ !empty($model->data['hero5_is_full']) && ($model->data['hero5_is_full'] == true) ? 'full' : 'half' }}">
                    <img src="{{ $model->image('hero5')->getSrc() }}"
						alt="MC2 Architects slideshow 5"
						data-src="{{ $model->image('hero5')->getSrc() }}"
						href="{{ $model->image('hero5')->getSrc() }}"
						data-index="4"
					>
				</div>
				@endif

				@if($model->image('hero6'))
				<div class="image {{ !empty($model->data['hero6_is_full']) && ($model->data['hero6_is_full'] == true) ? 'full' : 'half'  }}">
                    <img src="{{ $model->image('hero6')->getSrc() }}"
						alt="MC2 Architects slideshow 6"
						data-src="{{ $model->image('hero6')->getSrc() }}"
						href="{{ $model->image('hero6')->getSrc() }}"
						data-index="5"
					>
				</div>
				@endif

				@if(!empty($model->data['content']))
					<div class="image content">
						<h3>{{ !empty($model->data['sub_heading']) ? $model->data['sub_heading'] : "" }}</h3>
						{!! !empty($model->data['content']) ? $model->data['content'] : "" !!}
					</div>
				@endif

			</div>
		</section>
		{{-- <section class="popup-container">

			<div class="img-container">
				@if($model->image('hero2'))
					<div class="slide">
						<img src="{{ $model->image('hero2')->getSrc() }}" alt="image 1">
					</div>
				@endif
				@if($model->image('hero3'))
					<div class="slide">
						<img src="{{ $model->image('hero3')->getSrc() }}" alt="image 1">
					</div>
				@endif
				@if($model->image('hero4'))
					<div class="slide">
						<img src="{{ $model->image('hero4')->getSrc() }}" alt="image 1">
					</div>
				@endif
				@if($model->image('hero5'))
					<div class="slide">
						<img src="{{ $model->image('hero5')->getSrc() }}" alt="image 1">
					</div>
				@endif
				@if($model->image('hero6'))
					<div class="slide">
						<img src="{{ $model->image('hero6')->getSrc() }}" alt="image 1">
					</div>
				@endif
			</div>

		</section> --}}
        <section class="slideshow-container">
			<div class="content-max-width">

				@if($model->sections->count())
		
					<p class="mob">MORE IMAGES & PLANS <img src="/images/long-arrow.png"></p>

					<div class="col1 product-slideshow">
						@foreach($model->sections as $section)
							<div class="slide" style="background-image:url({{$section->image->getSrc()}});"></div>
						@endforeach  
					</div>
					<div class="col2 dots desktop">
						<p>MORE IMAGES & PLANS <img src="/images/long-arrow.svg"></p>
						@foreach($model->sections as $indexKey => $section)
							<div class="dot" data-dot="{{$indexKey}}" style="background-image:url({{ $section->image->getSrc() }});"></div>
						@endforeach
                </div>

				@endif

			</div>
		</section>

	</main>
@endsection

@push('scripts')
	<script type="text/javascript">

		$('.before .center').addClass('on');

		var allMods = $(".image");

		// Already visible modules
		allMods.each(function(i, el) {
			var el = $(el);
			if (el.visible(true)) {
				el.addClass("already-visible"); 
			} 
		});

		$(window).scroll(function(event) {
		
			allMods.each(function(i, el) {
				var el = $(el);
				if (el.visible(true)) {
					el.addClass("come-in"); 
				} 
			});

			if ( $('.site-footer').visible(true)) {
				$('.site-footer').addClass("come-in"); 
			}

            if ( $('.title-container h1').visible(true)) {
				$('.title-container h1').addClass("border"); 
			}  
		
		});

		$(document).ready(function (){

            setTimeout(function() {
                $('.hero-container').addClass('loaded');
			}, 800);

            setTimeout(function() {
				$('.js-scroll-down').trigger('click');
			}, 2200);

        });


        $('.product-slideshow').slick({
			infinite: true,
			arrows: false,
			dots: true,
			slidesToShow: 1,
			speed: 600,
			centerMode: true,
  			autoplaySpeed: 5000,
			// adaptiveHeight: true,
			fade: true,
		});

        $(".dot").click(function(e){
            e.preventDefault();

            $('.dots .dot').not(this).removeClass('active');
            $(this).addClass('active');

            var slideIndex = $(this).attr('data-dot');
            $(".slick-slider").slick("goTo", slideIndex);
        });

		$('.dot:first-of-type').addClass('active');


    </script>
@endpush