@extends('layouts.app')

@section('content')
    <div class="pages-container">
        <h1>Redirects</h1>
        <hr>
        <div class="row">
            <div class="span12">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-primary loading-btn" data-original="Add New" data-url="{{ route('admin.redirects.create') }}">
                                Add New
                            </button>
                        </div>
                        <div class="col-xs-6 align-right">
                            @include('.partials._search', ['target' => '.redirects-index'])
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

        @include('redirects._table', ['redirects' => $redirects])
    </div>
@endsection