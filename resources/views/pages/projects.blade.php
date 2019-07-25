@extends('layouts.app')

@section('content')
	<main role="main" class="main page-projects page-projects-v2">
        {{-- <div class="before">

            <div class="center">
                <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                <p>PROJECTS</p>
            </div>

        </div> --}}
		<section class="hero-container" style="background-image: url({{ getImage($model, '/images/hero2.jpg', null) }});">

            <div class="before">

                <div class="center">
                    <img src="/images/logo.svg" alt="Mc2 Architects Logo">
                    <p>{{trans('menu.projects')}}</p>
                    
                </div>

            </div>

			<a class="js-scroll-down scroller">
				<img src="/images/black-arrow.png">
			</a>

		</section>

        <section class="title-container">
            <div class="content-max-width">

                <h1>{{ Session::get('applocale') == 'cn' ? trans('pages.projectsTitle') : $model->title }}</h1>
                <h2>{{$model->data['lead_copy']}}</h2>

            </div>
		</section>
        <section class="sort-container">
			<div class="content-max-width">
                <div class="wrap">
                    <p>{{trans('pages.categories')}}</p>
                    <select name="sort-categories" id="sort-categories" class="custom-select-dropdown">
                        <option data-option="all" value="all">All</option>
                        @foreach($categories as $category)
                            <option data-option="{{$category->id}}" value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </section>
		<section class="detail-container">
			<div class="content-max-width">
                <div class="projects project-list">

                    @foreach($subPages as $page)
                        <a class="project-item" data-category="all,{{implode(",",pageCategoryList($page->id))}}" href="/project/{{$page->slug}}">
                            
                            @if(isset($page->data['featured_project']))
                                {{ $image_hero = $page->data['featured_project'] }}
                                <img src="{{ ($page->image($image_hero)) ? $page->image($image_hero)->getSrc() : null }}" alt="{{ $page->title }}">
                            @elseif( !empty($page->image('hero')) )
                                <img src="{{ ($page->image('hero')) ? $page->image('hero')->getSrc() : null }}" alt="{{ $page->title }}">
                                <p>{{$page->title}}</p>
                            @endif
                            <div class="owner">
                                <p>{{$page->title}}</p>
                                <p>{{$page->data['location']}}</p>
                            </div>
                        </a>
                    @endforeach
			    </div>
            </div>
		</section>
        <section class="pagination-module">

            <a href="{{$subPages->nextPageUrl()}}" class="older">
                <span class="icon-angle-left"></span>
                @lang('pages.previousProjects')
            </a>
            <a href="{{$subPages->previousPageUrl()}}" class="newer">
                @lang('pages.nextProjects')
                <span class="icon-angle-right"></span>
            </a>
        </section>

	</main>
@endsection

@push('scripts')
	<script type="text/javascript">

		$(document).ready(function (){

            $('.hero-container .center').addClass('on');
            $('.hamburger').addClass('color-change');
            
            setTimeout(function() {
                $('.hero-container').addClass('loaded');
                $('.title-container h1').addClass("border");
			}, 800);

            $(".js-scroll-down").click(function (){
                disable_scroll();
                $('html, body').stop().animate({scrollTop: $(".title-container").offset().top - 80}, 1500, function() {
                    disable_scroll();
                });
            });

            setTimeout(function() {
				$('.js-scroll-down').trigger('click');
			}, 2200);

        });

        var allMods = $(".projects a");

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

        $('select#sort-categories').change(function() {
            var filter = $(this).val()
            filterList(filter);
        });

        function filterList(value) {
            var list = $(".project-list .project-item");
            $(list).fadeOut("fast");
            if (value == "all") {
                $(".project-list").find("a").each(function (i) {
                    $(this).delay(200).slideDown("fast");
                });
            } else {
                //Notice this *=" <- This means that if the data-category contains multiple options, it will find them
                //Ex: data-category="all, Cat1, Cat2"
                $(".project-list").find("a[data-category*=" + value + "]").each(function (i) {
                    $(this).delay(200).slideDown("fast");
                });
            }
        }

    </script>
@endpush