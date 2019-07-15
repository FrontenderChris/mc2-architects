<!-- Cropping modal -->
<div class="modal fade" id="cropper-model-{{ $uniqueKey }}" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" action="{{ route('admin.images.crop') }}" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">Image Upload</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <div class="col-md-10">
                            <!-- Upload image and data -->
                            <div class="avatar-upload">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <label for="avatarInput">Local upload</label>
                                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                <input type="hidden" class="new_width" name="new_width" />
                                <input type="hidden" class="new_height" name="new_height" />

                                <p class="recommended-size"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            @if (isset($image) && !empty($image->id))
                                <button type="button" class="btn btn-danger btn-block do-delete-crop" data-target="{{ route('admin.images.destroy', $image->id) }}">Delete</button>
                            @endif
                        </div>
                        <!-- Crop and preview -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <!-- <div class="avatar-preview preview-md"></div>-->
                                <!--<div class="avatar-preview preview-sm"></div>-->
                            </div>
                        </div>
                        <div class="row avatar-btns">
                            <div class="col-md-9">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary do-zoom" data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip">
                                          <span class="fa fa-search-plus"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary do-zoom" data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip">
                                          <span class="fa fa-search-minus"></span>
                                        </span>
                                    </button>
                                </div>
                                <!--<div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleX&quot;, -1)">
                                          <span class="fa fa-arrows-h"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleY&quot;-1)">
                                          <span class="fa fa-arrows-v"></span>
                                        </span>
                                    </button>
                                </div>-->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary do-reset" title="Reset">
                                        <span class="docs-tooltip" data-toggle="tooltip">
                                          <span class="fa fa-refresh"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </form>
        </div>
    </div>
</div><!-- /.modal -->