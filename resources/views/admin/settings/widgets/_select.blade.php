<div class="form-group">
    {{ Form::label($setting->label, null, ['class' => 'col-sm-2 control-label' . ($setting->isRequired() ? ' required' : '')]) }}
    <div class="col-sm-10">
        {{ Form::select($setting->key, $setting->data, $setting->value, ['class' => 'form-control']) }}
    </div>
</div>