<div class="col-xs-8 vcenter title-col">
    @if (pagesSortable($model))
        <span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;
    @endif
    <span class="title">{{ $model->title }}</span>
</div><!--
--><div class="col-xs-4 align-right vcenter">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.pages.edit', $model->id) }}">
            <span class="glyphicon glyphicon-pencil"></span>
        </button>
        @if (config('products.canDeleteAll') || $model->is_dynamic)
            <button type="button" class="btn btn-default do-toggle-visibility" title="Toggle Visibility" data-target="{{ route('admin.pages.toggle', $model->id) }}">
                @if ($model->is_enabled)
                    <span class="glyphicon glyphicon-eye-open"></span>
                @else
                    <span class="glyphicon glyphicon-eye-close"></span>
                @endif
            </button>
            <button type="button" class="btn btn-default do-delete-page" data-target="{{ route('admin.pages.destroy', $model->id) }}" title="Delete">
                <span class="glyphicon glyphicon-trash"></span>
            </button>
        @endif
    </div>
</div>