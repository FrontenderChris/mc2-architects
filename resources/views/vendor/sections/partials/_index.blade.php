<div class="tab-content tab-{{ (isset($tabTitle) ? $tabTitle : 'sections') }}" style="{{ request()->has('section') ? 'display: block;' : '' }}">
    <div class="section-container">
        <div class="row">
            <div class="span12">
                <div class="well">
                    <div class="row">
                        <div class="col-xs-6">
                            @if ($forms = !empty($forms) ? $forms : sectionForms( !empty($exclude) ? $exclude : []))
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Add New &nbsp;&nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($forms as $template)
                                        <li><a href="{{ route('admin.sections.create', ['form' => $template, 'pageId' => $page->id]) }}">{{ readableFormName($template) }} Section</a></li>
                                    @endforeach
                                </ul>
                            @else
                                <button type="button" class="btn btn-primary loading-btn" data-original="Add New" data-url="{{ route('admin.sections.create', ['form' => '', 'pageId' => $page->id]) }}">
                                    Add New
                                </button>
                            @endif
                        </div>
                        <div class="col-xs-6 align-right">
                            @include('.partials._search', ['target' => '.sections-index'])
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

        <div class="sections-index container-fluid div-table sortable" data-sort-url="{{ route('admin.sections.sort') }}">
            <div class="row table-heading">
                <div class="col-xs-9">
                    <strong>Name</strong>
                </div>
                <div class="col-xs-3 align-right">
                    <strong>Actions</strong>
                </div>
            </div>
            @foreach ($page->sections as $section)
                @include('sections::section._row', ['model' => $section])
            @endforeach
        </div>
    </div>
</div>