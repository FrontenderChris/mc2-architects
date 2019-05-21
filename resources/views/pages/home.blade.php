@extends('layouts.app')

@section('content')
	<main role="main" class="main page-home">
		<section class="hero-container">
			
			<div class="logo">
				<img src="/images/logo-decon/mc-white.svg" alt="mc2-Architects logo" class="mc">
				<img src="/images/logo-decon/2-white.svg" alt="mc2-Architects logo" class="two">
				<img src="/images/logo-decon/horizontal-white.svg" alt="mc2-Architects logo" class="bottom">
				<img src="/images/logo-decon/vertical-white.svg" alt="mc2-Architects logo" class="right">
				{{-- <img src="/images/logo-decon/architects2.png" alt="mc2-Architects logo" class="architects"> --}}
				{{-- <img src="/images/logo-decon/logo-white.svg" alt="mc2-Architects logo" class="full-logo"> --}}
			</div>

			<a class="js-scroll-down2 scroller">
				<img src="/images/white-arrow.png">
			</a>

		</section>
		<section class="project-container">
			<div class="content-max-width">

				{{-- @foreach($subPages as $page)
					<a class="image" href="/project/{{$page->slug}}">
						@if(isset($page->data['featured_project']))
						@php($image_hero = $page->data['featured_project'])
						<img src="{{ ($page->image($image_hero)) ? $page->image($image_hero)->getSrc() : null }}" alt="{{ $page->title }}">
						<p>{{$page->title}}</p>
						@elseif( !empty($page->image('hero')) )
						<img src="{{ ($page->image('hero')) ? $page->image('hero')->getSrc() : null }}" alt="{{ $page->title }}">
						<p>{{$page->title}}</p>
						@endif
					</a>
				@endforeach --}}

				@foreach($page->images as $page)
					<a class="image" href="{{$page->url}}" style="max-width: {{ !empty($page->data['width']) ? $page->data['width'].'px' : '100%' }}; margin-right:{{ !empty($page->data['margin_right']) ? $page->data['margin_right'].'px' : '0px'}}; margin-bottom:{{ !empty($page->data['margin_bottom']) ? $page->data['margin_bottom'].'px' : '0px' }}; margin-left:{{ !empty($page->data['margin_left']) ? $page->data['margin_left'].'px' : '0px'}};">
						@if(!empty($page))
							<img src="{{ ($page) ? $page->getSrc() : null }}" alt="{{ $page->title }}">
							<p>{{$page->title}}</p>
						@endif
					</a>
				@endforeach

			</div>
		</section>
	</main>
@endsection

@push('scripts')
	<script type="text/javascript">

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
		
		});

		$(document).ready(function (){

			$("body").addClass('black');

			$(".js-scroll-down2").click(function (){
                $('html, body').animate({
                    scrollTop: $(".project-container").offset().top - 80
                }, 2500);
            });

			$( ".bottom" ).delay( 100 ).addClass('fadeIn');
			$( ".mc, .two, .architects" ).delay( 1200 ).addClass('fadeIn');
			$( ".right" ).delay( 1000 ).addClass('rotate');

			setTimeout(function() {
				$('.js-scroll-down2').trigger('click');
			}, 1800);

        });


    </script>
@endpush