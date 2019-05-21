{{ Form::open(['route' => $route, 'method' => 'GET']) }}
    <div class="has-input-icon right-input-icon clearable-input search-php">
        <i class="glyphicon glyphicon-search"></i>
        <input type="text" class="form-control search-input" name="search" placeholder="Search" value="{{ (!empty($search) ? $search : '') }}">
        <span data-clear-input data-location="{{ route($route) }}">&times;</span>
    </div>
    <button class="btn btn-primary" type="submit">Search</button>
{{ Form::close() }}