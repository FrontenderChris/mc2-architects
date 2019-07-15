@extends('layouts.app')

@section('content')
    <div class="pages-container">
        <h1>Subscribers</h1>
        <hr>

        <div class="row">
            <div class="span12">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-primary" data-url="{{ route('admin.subscribers.export') }}">
                                Export CSV
                            </button>
                        </div>
                        <div class="col-xs-6 align-right">
                            @include('.partials._searchPhp', ['route' => 'admin.subscribers.index'])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-index container-fluid div-table">
            <div class="row table-heading">
                <div class="col-xs-6">
                    <strong>Email</strong>
                </div>
            </div>
            @foreach ($subscribers as $model)
                <div class="row">
                    <div class="col-xs-6 vcenter">
                        {{ $model->email }}
                    </div>
                </div>
            @endforeach
        </div>

        @if (!empty($search))
            {!! $subscribers->appends(['search' => $search])->links() !!}
        @else
            {!! $subscribers->links() !!}
        @endif

    </div>
@endsection