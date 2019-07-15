<div class="is-cropper" data-key="{{ $uniqueKey }}" id="cropper-input-{{ $uniqueKey }}" data-width="{{ $width }}" data-height="{{ $height }}">
    <div class="form-group">
        <label class="col-sm-2 control-label {{ (!empty($required) ? 'required' : '') }}">{{ (empty($label) ? 'Image' : $label) }}</label>
        <input type="hidden" name="{{ (!empty($inputName) ? $inputName : 'image') }}" value="" class="image-field" autocomplete="off" />
        <div class="col-sm-10">
            <div class="avatar-view do-show-cropper" title="Change this image" {!! (!empty($image) && $image->exists() ?: 'style="display:none;"') !!}>
                @if (!empty($image) && $image->exists())
                    <img src="{{ $image->getSrc() }}" alt="">
                @endif
            </div>
            @if (empty($image) || (isset($image) && !$image->exists()))
                <div class="hide-after-crop">
                    <button type="button" class="do-show-cropper">Add Image</button>
                    <span id="cropper-filename-{{ $uniqueKey }}"></span>
                </div>
            @endif
        </div>
    </div>

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

    @if (!empty($url))
        <div class="form-group url-field">
            <label class="col-sm-2 control-label">{{ (empty($url['label']) ? 'URL' : $url['label']) }}</label>
            <div class="col-sm-5">
                {{ Form::text($url['name'], (!empty($image) ? $image->url : null), ['class' => 'form-control', 'maxlength' => 255]) }}
            </div>
        </div>
    @endif
</div>