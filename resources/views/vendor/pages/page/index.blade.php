@extends('layouts.app')

@section('content')
    <div class="pages-container">
        <h1>Pages</h1>
        <hr>
        <div class="row">
            <div class="span12">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6">
                            @if (config('pages.canCreate'))
                                @if ($forms = pageForms(['_contact', '_home', '_seo']))
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Add New &nbsp;&nbsp;<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($forms as $template)
                                            <li><a href="{{ route('admin.pages.create', ['form' => $template]) }}">{{ readableFormName($template) }} Page</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <button type="button" class="btn btn-primary loading-btn" data-original="Add New" data-url="{{ route('admin.pages.create', ['form' => '']) }}">
                                        Add New
                                    </button>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-6 align-right">
                            @include('.partials._search', ['target' => '.page-index'])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Session::has('error-msg'))
            <p class="alert alert-danger">{!! Session::get('error-msg') !!}</p>
        @endif

        <div class="alert alert-success" style="display: none;"></div>
        <div class="alert alert-danger" style="display: none;"></div>

        @include('pages::page._table', ['pages' => $pages])
    </div>
@endsection