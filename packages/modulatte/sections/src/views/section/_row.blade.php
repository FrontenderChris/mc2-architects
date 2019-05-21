<div class="row" id="sections_{{ $model->id }}" data-search="{{ strtolower($model->title) }}">
    <div class="col-xs-8 vcenter">
        <span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;
        <span class="title">{{ $model->title }}</span>
    </div><!--
    --><div class="col-xs-4 align-right vcenter">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.sections.edit', $model->id) }}">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <button type="button" class="btn btn-default do-toggle-visibility" title="Toggle Visibility" data-target="{{ route('admin.sections.toggle', $model->id) }}">
                @if ($model->is_enabled)
                    <span class="glyphicon glyphicon-eye-open"></span>
                @else
                    <span class="glyphicon glyphicon-eye-close"></span>
                @endif
            </button>
            <button type="button" class="btn btn-default do-delete-row" data-target="{{ route('admin.sections.destroy', $model->id) }}"  title="Delete">
                <span class="glyphicon glyphicon-trash"></span>
            </button>
        </div>
    </div>
</div>