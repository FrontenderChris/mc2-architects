<div class="collapse category-sortable child_{{ $id }}" data-sort-url="{{ route('admin.categories.sort') }}" data-id="{{ $id }}">
    @foreach ($children as $child)
        <div class="inner-row {{ ($child->hasChildren() ? 'has-children' : '') }}" id="categories_{{ $child->id }}" data-id="{{ $child->id }}">
            <div class="col-xs-4 vcenter">
                <button type="button" class="btn btn-xs btn-default expand-btn do-expand-children" data-toggle="collapse" data-target=".child_{{ $child->id }}" {!! (!$child->hasChildren() ? 'style="display:none;"' : '') !!}>
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
                &nbsp;&nbsp;
                <span class="glyphicon glyphicon-resize-vertical"></span>&nbsp;
                <a href="{{ route('admin.categories.edit', $child->id) }}">{{ $child->title }}</a>
            </div><!--
            --><div class="col-xs-4 vcenter">
                {{ $child->slug }}
            </div><!--
            --><div class="col-xs-4 align-right vcenter">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.categories.edit', $child->id) }}">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button type="button" class="btn btn-default do-toggle-visibility" title="Toggle Visibility" data-target="{{ route('admin.categories.toggle', $child->id) }}">
                        @if ($child->is_enabled)
                            <span class="glyphicon glyphicon-eye-open"></span>
                        @else
                            <span class="glyphicon glyphicon-eye-close"></span>
                        @endif
                    </button>
                    <button type="button" class="btn btn-default do-delete-row" data-target="{{ route('admin.categories.destroy', $child->id) }}"  title="Delete">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </div>

            @if ($child->hasChildren())
                @include('categories::admin.category.partials._childRow', ['children' => $child->children, 'id' => $child->id])
            @endif

        </div>
    @endforeach
</div>