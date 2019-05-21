@extends('layouts.app')

@section('content')
        <!--   Start: Main Content Area    -->
<section role="main" class="main page-about">
    <section class="body-container">
        <div class="content-max-width">
            <h1>{!! title($model->title) !!}</h1>

            @if (!empty($model->lead_copy))
                <p class="leadcopy">{{ $model->lead_copy }}</p>
            @endif

            <div class="wysiwyg">
                {!! $model->content !!}
            </div>
        </div>
    </section>
</section>
<!--   End: Main Content Area    -->
@endsection