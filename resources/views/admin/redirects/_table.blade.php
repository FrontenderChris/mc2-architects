<div class="redirects-index container-fluid div-table">
    @if ($redirects->isEmpty())
        <p><br>No redirects found. <a href="{{ route('admin.redirects.create') }}">Click here</a> to add some.</p>
    @else
        <div class="row table-heading">
            <div class="col-xs-5">
                <strong>Redirect From</strong>
            </div>
            <div class="col-xs-5">
                <strong>Redirect To</strong>
            </div>
            <div class="col-xs-2 align-right">
                <strong>Actions</strong>
            </div>
        </div>

        @foreach ($redirects as $model)
            <div class="row" data-search="{{ strtolower($model->redirect_from . $model->redirect_to) }}">
                <div class="col-xs-5 vcenter">
                    <span class="title">{{ $model->redirect_from }}</span>
                </div><!--
                --><div class="col-xs-5 vcenter">
                    <span class="title">{{ $model->redirect_to }}</span>
                </div><!--
                --><div class="col-xs-2 align-right vcenter">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.redirects.edit', $model->id) }}">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button type="button" class="btn btn-default do-toggle-visibility" title="Toggle Visibility" data-target="{{ route('admin.redirects.toggle', $model->id) }}">
                            @if ($model->is_enabled)
                                <span class="glyphicon glyphicon-eye-open"></span>
                            @else
                                <span class="glyphicon glyphicon-eye-close"></span>
                            @endif
                        </button>
                        <button type="button" class="btn btn-default do-delete-row" data-target="{{ route('admin.redirects.destroy', $model->id) }}"  title="Delete">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>