@extends('layouts.app')

@section('content')
	<main role="main" class="main page-about">
           
		<section class="hero-container" style="background-image: url({{ getImage($page, '/images/hero2.jpg', null) }});">

            <div class="before">

                <div class="center">
                    <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                    <p>{{trans('menu.aboutUs')}}</p>
                </div>

            </div>

			<a class="js-scroll-down scroller">
				<img src="/images/black-arrow.png">
			</a>

		</section>
        <section class="title-container">
            <div class="content-max-width">
                @if($page->count())
                    <h1>{{ Session::get('applocale') == 'cn' ? trans('pages.aboutUsTitle') : $page->title }}</h1>
                    <h2>{{ $page->data['lead_copy'] }}</h2>
                @endif
            </div>
		</section>
		<section class="detail-container">
			<div class="content-narrow-width">
                @if (Session::get('applocale') == 'en')
                    {!! $page->data['content'] !!}
                @else
                    {{ trans('pages.aboutUsContent')  }}
                @endif
			</div>
		</section>

	</main>
@endsection

@push('scripts')
	<script type="text/javascript">

		$(document).ready(function (){

            $('.before .center').addClass('on');

			$(".js-scroll-down").click(function (){
                disable_scroll();
                $('html, body').stop().animate({scrollTop: $(".title-container").offset().top - 80}, 1500, function() {
                    disable_scroll();
                });
            });

            setTimeout(function() {
                $('.hero-container').addClass('loaded');
			}, 800);

            setTimeout(function() {
				$('.js-scroll-down').trigger('click');
			}, 2200);

        });

    </script>
@endpush