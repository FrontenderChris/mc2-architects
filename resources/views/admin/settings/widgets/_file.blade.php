<div class="form-group">
    {{ Form::label($setting->label, null, ['class' => 'col-sm-2 control-label' . ($setting->isRequired() ? ' required' : '')]) }}
    <div class="col-sm-6">
        {{ Form::file($setting->key) }}
    </div>
    @if ($setting && $setting->image)
        <div class="col-sm-4 text-right">
            <img src="{{ $setting->image->getSrc() }}" alt="" class="preview-img" />
        </div>
    @endif
</div>