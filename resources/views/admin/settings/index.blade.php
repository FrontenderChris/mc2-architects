@extends('layouts.app')

@section('content')
    <div class="cart-settings-update">
        <h1>Site Settings</h1>
        <hr>

        @include('partials._messages')

        <ul class="nav nav-tabs">
            @foreach ($groups as $group => $settings)
                <li class="{{ (str_slug($group) == 'general' ? 'active' : '') }}">
                    <a href="#" class="do-show-content" data-show=".tab-{{ str_slug($group) }}">{{ $group }}</a>
                </li>
            @endforeach
        </ul>

        {{ Form::open(['route'=>['admin.settings.update'], 'class' => 'form-horizontal', 'files'=> true]) }}
        @foreach ($groups as $group => $settings)
            <div class="tab-content tab-{{ str_slug($group) }}" style="{{ (str_slug($group) == 'general' ? 'display:block;' : '') }}">
                @if ($group == 'E-Commerce Emails')
                    <table class="table table-striped table-responsive order-index" width="100%">
                        <thead class="thead-inverse">
                        <tr>
                            <th>Type</th>
                            <th class="align-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @endif

                        @foreach ($settings as $key => $setting)
                            @include('settings.widgets.' . $setting->widget, ['setting' => $setting])
                        @endforeach

                        @if ($group == 'E-Commerce Emails')
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach

        <div class="form-group add-margin-40">
            {{ Form::submit('Save', ['class' => 'btn btn-primary form-control loading-btn']) }}
        </div>
        {{ Form::close() }}

        @include('cropper::_modal', [
            'uniqueKey' => 'logo',
        ])
    </div>
@endsection


