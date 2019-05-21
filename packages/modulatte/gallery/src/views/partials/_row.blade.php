<div class="row" id="gallery_{{ $model->id }}" data-search="{{ strtolower($model->title) }}">
    <div class="col-xs-1 vcenter">
        <img src="{{ (!empty($model->file) ? $model->getSrc() : \App\Helpers\AdminHelper::getImgSrc('white.png')) }}" alt="" class="img-thumbnail lazyload" data-src="{{ $model->getSrc() }}" />
    </div><!--
    --><div class="col-xs-8 vcenter">
        <span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;
        <span class="title">{!! title($model->title) !!}</span>
    </div><!--
    --><div class="col-xs-3 align-right vcenter">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.gallery.edit', [
                $model->id,
                'route' => encodeSlashes(url(request()->path()))
            ]) }}">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <button type="button" class="btn btn-default do-delete-row" data-target="{{ route('admin.gallery.destroy', $model->id) }}"  title="Delete">
                <span class="glyphicon glyphicon-trash"></span>
            </button>
        </div>
    </div>
</div>