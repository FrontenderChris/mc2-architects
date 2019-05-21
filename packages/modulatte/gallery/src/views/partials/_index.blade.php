<div class="gallery-container">
    <div class="row">
        <div class="span12">
            <div class="well">
                <div class="row">
                    <div class="col-xs-6">
                        <button
                            type="button"
                            class="btn btn-primary loading-btn"
                            data-original="Add New"
                            data-url="{{ route('admin.gallery.create', [
                                'class' => encodeSlashes(get_class($parent), '\\'),
                                'id' => $parent->id,
                                'width' => $width,
                                'height' => $height,
                                'route' => encodeSlashes(url(request()->path())),
                            ]) }}">
                            Add New
                        </button>
                    </div>
                    <div class="col-xs-6 align-right">
                        @include('.partials._search', ['target' => '.gallery-index'])
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

    <div class="gallery-index container-fluid div-table sortable" data-sort-url="{{ route('admin.gallery.sort') }}">
        <div class="row table-heading">
            <div class="col-xs-9">
                <strong>Name</strong>
            </div>
            <div class="col-xs-3 align-right">
                <strong>Actions</strong>
            </div>
        </div>
        @foreach ((!empty($data) ? $data : $parent->images) as $model)
            @if (empty($exclude) || (!empty($exclude) && !in_array($model->title, $exclude)))
                @include('gallery::partials._row')
            @endif
        @endforeach
    </div>
</div>