<div class="form-group">
    {{ Form::label($setting->label, null, ['class' => 'col-sm-2 control-label' . ($setting->isRequired() ? ' required' : '')]) }}
    <div class="col-sm-10">
        {{ Form::textarea($setting->key, $setting->value, ['class' => 'form-control']) }}
    </div>
</div>