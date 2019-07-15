(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals.
        factory(jQuery);
    }
})(function ($) {

    'use strict';

    var console = window.console || { log: function () {} };

    function CropAvatar($element, $modal) {
        this.$container = $element;

        this.$avatarView = this.$container.find('.avatar-view');
        this.$avatar = this.$avatarView.find('img');
        this.$showCropper = this.$container.find('.do-show-cropper');
        this.$avatarModal = $modal;
        this.$loading = this.$container.find('.loading');

        this.$avatarForm = this.$avatarModal.find('.avatar-form');
        this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
        this.$avatarSrc = this.$avatarForm.find('.avatar-src');
        this.$avatarData = this.$avatarForm.find('.avatar-data');
        this.$avatarInput = this.$avatarForm.find('.avatar-input');
        this.$avatarSave = this.$avatarForm.find('.avatar-save');
        this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

        this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
        this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

        this.init();
    }

    CropAvatar.prototype = {
        constructor: CropAvatar,

        support: {
            fileList: !!$('<input type="file">').prop('files'),
            blobURLs: !!window.URL && URL.createObjectURL,
            formData: !!window.FormData
        },

        init: function () {
            this.support.datauri = this.support.fileList && this.support.blobURLs;

            if (!this.support.formData) {
                this.initIframe();
            }

            this.initDimensions();
            this.initTooltip();
            this.initModal();
            this.addListener();
        },

        addListener: function () {
            //this.$avatarView.on('click', $.proxy(this.click, this));
            this.$showCropper.on('click', $.proxy(this.click, this));
            this.$avatarInput.on('change', $.proxy(this.change, this));
            this.$avatarForm.on('submit', $.proxy(this.submit, this));
            this.$avatarBtns.on('click', $.proxy(this.rotate, this));
        },

        initDimensions: function () {
            this.newWidth = this.$container.data('width');
            this.newHeight = this.$container.data('height');
            if (parseInt(this.newWidth) > 0 && parseInt(this.newHeight) > 0) {
                this.aspectRatio = (this.newWidth / this.newHeight);
                this.$avatarForm.find('.new_width').val(this.newWidth);
                this.$avatarForm.find('.new_height').val(this.newHeight);
            }
            else {
                this.aspectRatio = null;
            }
        },

        initTooltip: function () {
            this.$avatarView.tooltip({
                placement: 'bottom'
            });
        },

        initModal: function () {
            if (this.newWidth > 0 && this.newHeight > 0)
                this.$avatarModal.find('.recommended-size').html('Recommended image size: ' + this.newWidth + 'px x ' + this.newHeight + 'px');

            this.$avatarModal.modal({
                show: false
            });
        },

        initPreview: function () {
            var url = this.$avatar.attr('src');

            if (url)
                this.$avatarPreview.html('<img src="' + url + '">');

            // Set the preview dimensions to auto when initially loading the modal - this is overwritten when image is uploaded
            if (this.$avatarPreview.find('img').length > 0)
                this.$avatarPreview.css({width: 'auto', height: 'auto'});
        },

        initIframe: function () {
            var target = 'upload-iframe-' + (new Date()).getTime();
            var $iframe = $('<iframe>').attr({
                name: target,
                src: ''
            });
            var _this = this;

            // Ready ifrmae
            $iframe.one('load', function () {

                // respond response
                $iframe.on('load', function () {
                    var data;

                    try {
                        data = $(this).contents().find('body').text();
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (data) {
                        try {
                            data = $.parseJSON(data);
                        } catch (e) {
                            console.log(e.message);
                        }

                        _this.submitDone(data);
                    } else {
                        _this.submitFail('Image upload failed!');
                    }

                    _this.submitEnd();

                });
            });

            this.$iframe = $iframe;
            this.$avatarForm.attr('target', target).after($iframe.hide());
        },

        click: function () {
            this.$avatarModal.modal('show');
            this.initPreview();
        },

        change: function () {
            var files;
            var file;

            if (this.support.datauri) {
                files = this.$avatarInput.prop('files');

                if (files.length > 0) {
                    file = files[0];

                    if (this.isImageFile(file)) {
                        if (this.url) {
                            URL.revokeObjectURL(this.url); // Revoke the old one
                        }

                        this.url = URL.createObjectURL(file);
                        this.startCropper();
                    }
                }
            } else {
                file = this.$avatarInput.val();

                if (this.isImageFile(file)) {
                    this.syncUpload();
                }
            }
        },

        submit: function () {
            if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
                return false;
            }

            if (this.support.formData) {
                this.ajaxUpload();
                return false;
            }
        },

        rotate: function (e) {
            var data;

            if (this.active) {
                data = $(e.target).data();

                if (data.method) {
                    this.$img.cropper(data.method, data.option);
                }
            }
        },

        isImageFile: function (file) {
            if (file.type) {
                return /^image\/\w+$/.test(file.type);
            } else {
                return /\.(jpg|jpeg|png|gif)$/.test(file);
            }
        },

        startCropper: function () {
            var _this = this;

            // Remove the auto widths we initially applied
            this.$avatarPreview.css({width: '', height: ''});

            if (this.active) {
                this.$img.cropper('replace', this.url);
            } else {
                this.$img = $('<img src="' + this.url + '">');
                this.$avatarWrapper.empty().html(this.$img);
                var options = {
                    cropBoxResizable: true,
                    dragMode: 'move',
                    preview: this.$avatarPreview.selector,
                    crop: function (e) {
                        var json = [
                            '{"x":' + e.x,
                            '"y":' + e.y,
                            '"height":' + e.height,
                            '"width":' + e.width,
                            '"scaleX":' + e.scaleX,
                            '"scaleY":' + e.scaleY,
                            '"rotate":' + e.rotate + '}'
                        ].join();

                        _this.$avatarData.val(json);
                    }
                };

                if (this.aspectRatio != null) {
                    options['aspectRatio'] = this.aspectRatio;
                    options['cropBoxResizable'] = false;
                }

                this.$img.cropper(options);

                var $img = this.$img;
                this.$avatarBtns.find('.do-zoom').click(function(){
                    $img.cropper('zoom', $(this).data('option'));
                });

                this.$avatarBtns.find('.do-reset').click(function(){
                    $img.cropper('reset');
                });

                this.active = true;
            }

            this.$avatarModal.one('hidden.bs.modal', function () {
                _this.$avatarPreview.empty();
                _this.stopCropper();
            });
        },

        stopCropper: function () {
            if (this.active) {
                this.$img.cropper('destroy');
                this.$img.remove();
                this.active = false;
            }
        },

        ajaxUpload: function () {
            var $newWidth = this.$avatarForm.find('[name=new_width]');
            var $newHeight = this.$avatarForm.find('[name=new_height]');
            var $newData = this.$avatarForm.find('[name=avatar_data]');

            // If widths are empty, it is a changeable crop area, so send the updated values
            if ($newWidth.val() == '' || $newHeight.val() == '') {
                var cropData = this.$img.cropper('getData');
                $newData.val(JSON.stringify(cropData));
                $newWidth.val(cropData.width);
                $newHeight.val(cropData.height);
            }

            var url = this.$avatarForm.attr('action');
            var data = new FormData(this.$avatarForm[0]);
            var _this = this;

            $.ajax(url, {
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,

                beforeSend: function () {
                    _this.submitStart();
                },

                success: function (data) {
                    _this.submitDone(data);
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    _this.submitFail(textStatus || errorThrown);
                },

                complete: function () {
                    _this.submitEnd();
                }
            });
        },

        syncUpload: function () {
            this.$avatarSave.click();
        },

        submitStart: function () {
            this.$loading.fadeIn();
        },

        submitDone: function (data) {
            if ($.isPlainObject(data) && data.state === 200) {
                if (data.result) {
                    this.url = data.result;
                    this.filename = data.filename;

                    if (this.support.datauri || this.uploaded) {
                        this.uploaded = false;
                        this.cropDone();
                    } else {
                        this.uploaded = true;
                        this.$avatarSrc.val(this.url);
                        this.startCropper();
                    }

                    this.$avatarInput.val('');
                } else if (data.message) {
                    this.alert(data.message);
                }
            } else {
                this.alert('Failed to response');
            }
        },

        submitFail: function (msg) {
            this.alert(msg);
        },

        submitEnd: function () {
            this.$loading.fadeOut();
        },

        cropDone: function () {
            this.$avatarForm.get(0).reset();
            this.$avatar.attr('src', this.url);
            this.stopCropper();
            this.$avatarModal.modal('hide');
            this.$container.find('.image-field').val(this.filename);

            // Add the avatar image and unhide if <img> doesnt exist
            if (this.$avatarView.find('img').length == 0) {
                this.$avatarView.html('<img src="' + this.url + '" />');
                this.$avatarView.show();
            } else {
                this.$avatarView.find('img').attr('src', this.url);
            }

            // If we have a form item, then hide this since the above <img> is replacing it
            if (this.$container.find('.hide-after-crop').length)
                this.$container.find('.hide-after-crop').hide();
        },

        alert: function (msg) {
            var $alert = [
                '<div class="alert alert-danger avatar-alert alert-dismissable">',
                '<button type="button" class="close" data-dismiss="alert">&times;</button>',
                msg,
                '</div>'
            ].join('');

            this.$avatarUpload.after($alert);
        }
    };

    $(function () {
        $('.is-cropper').each(function(){
            var key = $(this).data('key');
            return new CropAvatar($('#cropper-input-' + key), $('#cropper-model-' + key));
        });

        $('.do-delete-crop').click(function(){
            var check = confirm('Are you sure you want to delete this item?');
            if (check) {
                $.ajax({
                    url: $(this).data('target'),
                    method: 'DELETE',
                    success: function(response){
                        if (response.status === 'error')
                            alert(response.msg);
                        else
                            location.reload();
                    },
                    error: function (response) {
                        processError(response);
                    }
                });
            }
        });
    });

});
