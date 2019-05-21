<div class="form-group">
    {{ Form::label($setting->label, null, ['class' => 'col-sm-2 control-label' . ($setting->isRequired() ? ' required' : '')]) }}
    <div class="col-sm-10">
        {{ Form::text($setting->key, $setting->value, ['class' => 'form-control', 'maxlength' => 100]) }}
    </div>
</div>