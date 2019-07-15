<div class="form-group">
    {{ Form::label('Name', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::text('user[name]', null, ['class' => 'form-control', 'maxlength' => 100]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Email', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::text('user[email]', null, ['class' => 'form-control', 'maxlength' => 100]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Password', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::password('user[password]', ['class' => 'form-control', 'maxlength' => 100]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Confirm Password', null, ['class' => 'col-sm-2 control-label required']) }}
    <div class="col-sm-10">
        {{ Form::password('user[confirm_password]', ['class' => 'form-control', 'maxlength' => 100]) }}
    </div>
</div>

@if (hasLoginPackage())
    <div class="form-group">
        {{ Form::label('User Role', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('role_id', role()->getList(), null, ['class' => 'form-control', 'data-placeholder' => 'User Role']) }}
        </div>
    </div>
@endif

<div class="form-group add-margin-40">
    {{ Form::submit('Save User', ['class' => 'btn btn-primary form-control']) }}
</div>