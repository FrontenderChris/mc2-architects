@extends('layouts.app')

@section('content')
	<main role="main" class="main page-team">

		<section class="hero-container" style="background-image: url({{ getImage($page, '/images/hero4.jpg', null) }});">

            <div class="before">

                <div class="center">
                    <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                    <p>{{trans('menu.profile')}}</p>
                </div>

            </div>

			<a class="js-scroll-down scroller">
				<img src="/images/black-arrow.png">
			</a>

		</section>
        <section class="title-container">
            <div class="content-max-width">

                <h1>{{ $page->title }}</h1>
                <h2>{{ $page->data['lead_copy'] }}</h2>

            </div>
		</section>
		<section class="detail-container">
			<div class="content-narrow-width">
                @foreach($page->sections as $section)
				<article>
                    <div class="image">
                        <img src="{{ $section->image->getSrc() }}" alt="{{ $section->title }}">
                    </div>
					<div class="info">
                        <h3>{{ $section->title }}</h3>
                        <h5>{{ $section->data['title'] }}</h5>
                        <div class="content">
                            {!! nl2br($section->data['content']) !!}
                        </div>
                        <a href="mailto:{{ $section->data['email'] }}" class="talk">{{ $section->data['email'] }}</a>
                        <a href="tel:{{ phoneable($section->data['phone']) }}" class="talk">{{ $section->data['phone'] }}</a>
					</div>
				</article>
                @endforeach
			</div>
		</section>

	</main>
@endsection

@push('scripts')
	<script type="text/javascript">

		$(document).ready(function (){

            $('.before .center').addClass('on');

            setTimeout(function() {
                $('.hero-container').addClass('loaded');
			}, 800);

            setTimeout(function() {
				$('.js-scroll-down').trigger('click');
			}, 2200);


        });

    </script>
@endpush