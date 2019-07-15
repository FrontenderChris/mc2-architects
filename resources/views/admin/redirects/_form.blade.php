<div class="form-group">
    {{ Form::label('Redirect From', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::text('redirect_from', null, ['class' => 'form-control do-filter-value', 'maxlength' => 255]) }}
        <small>DO NOT use full URL such as <i>http://something.com/mypage</i>. Instead use <i>mypage</i></small>
    </div>
</div>
<div class="form-group">
    {{ Form::label('Redirect To', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::text('redirect_to', null, ['class' => 'form-control do-filter-value', 'maxlength' => 255]) }}
        <small>DO NOT use full URL such as <i>http://something.com/mypage</i>. Instead use <i>mypage</i></small>
    </div>
</div>