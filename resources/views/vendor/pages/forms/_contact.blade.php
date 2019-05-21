{!! pageOpenForm($form, (isset($model) ? $model : null)) !!}
    @include('pages::page._nav')

    {{------------------------------- EDIT THE FORM BELOW ------------------------------}}
    <div class="tab-content tab-main contact-form" style="display: block;">

        <div class="form-group">
            {{ Form::label('Title', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::text('title', null, ['class' => 'form-control do-slugify', 'maxlength' => 100]) }}
            </div>
        </div>
    
        <div class="form-group">
            {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::text('slug', null, ['class' => 'form-control is-slug', 'maxlength' => 100]) }}
            </div>
        </div>
            
        <div class="form-group">
            {{ Form::label('Lead Copy', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('data[lead_copy]', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Phone 1', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::text('data[phone]', null, ['class' => 'form-control', 'maxlength' => 100]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Email', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::text('data[email]', null, ['class' => 'form-control', 'maxlength' => 100]) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Physical Address', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::textarea('data[physical_address]', null, ['class' => 'form-control do-push-address', 'rows' => 4]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Postal Address', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::textarea('data[postal_address]', null, ['class' => 'form-control', 'rows' => 4]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Map Location', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::hidden('data[lat]', null, ['id' => 'latval']) }}
                {{ Form::hidden('data[lng]', null, ['id' => 'longval']) }}
                <div class="form-inline map-search">
                    <input class="form-control address-input" placeholder="Search for Address">
                    <button type="button" class="btn btn-default do-search-address">Search</button>
                </div>
                <div class="map-selector">
                    <small>Drag the marker below to update Latitude and Longitude.</small>
                    <div id="mapitems"></div>
                </div>
            </div>
        </div>
        <br>
        @include('cropper::_input', [
            'uniqueKey' => '1',
            'width' => 1500,
            'height' => 1000,
            'label' => 'Bg Image',
            'inputName' => 'image[file]',
            'required' => true,
            'image' => (isset($model) ? $model->image : null),
        ])

        @include('pages::partials._submit')
    </div>
    {{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

    @include('pages::partials._seo')
{{ pageCloseForm() }}

@include('cropper::_modal', ['uniqueKey' => '1'])

@section('footer')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('MAPS_API_KEY') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var lng = {!! (isset($model) && !empty($model->data['lng']) ? $model->data['lng'] : \Modulatte\Pages\Models\Page::DEFAULT_LNG) !!};
            var lat = {!! (isset($model) && !empty($model->data['lat']) ? $model->data['lat'] : \Modulatte\Pages\Models\Page::DEFAULT_LAT) !!};
            if_gmap_init(lng, lat, 15);
        });
    </script>
@endsection

