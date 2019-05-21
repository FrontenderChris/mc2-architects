<div class="page-index container-fluid div-table {{ (config('pages.sortable') ? 'sortable' : '') }}" data-sort-url="{{ route('admin.pages.sort') }}">
    @if ($pages->isEmpty())
        <p><br>No pages found.</p>
    @else
        <div class="row table-heading">
            <div class="col-xs-9">
                <strong>Name</strong>
            </div>
            <div class="col-xs-3 align-right">
                <strong>Actions</strong>
            </div>
        </div>

        @foreach ($pages as $model)
            <div class="row {{ ($model->hasChildren() ? 'has-children' : '') }}" id="pages_{{ $model->id }}" data-search="{{ strtolower($model->title . $model->slug) }}">
                @include('projects._row', ['model' => $model])

                @if ($model->hasChildren())
                    <div class="page-children {{ (config('pages.subPagesSortable') ? 'pages-child-sortable' : '') }}" data-sort-url="{{ route('admin.pages.sort') }}">
                        @foreach ($model->children as $key => $child)
                            <div
                                class="child-page"
                                id="pages_{{ $child->id }}"
                                data-search="{{ strtolower($child->title . $child->slug) }}"
                            >
                                @include('projects._row', ['model' => $child])
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>