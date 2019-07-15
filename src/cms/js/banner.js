/*
 * BANNER (CONTENT) FUNCTIONALITY
 */
var $bannerContainer = $('.banner-container');
var $bannerIndex = $('.banner-index');
var $bannerAddModal = $('#banner-add');
var $bannerEditModal = $('#banner-edit');

var banner = new Banner('banners', $bannerContainer, $bannerIndex);

$(document).ready(function(){
    $bannerAddModal.find('.do-save').click(function(){
        banner.create();
    });

    $bannerEditModal.find('.do-save').click(function(){
        banner.edit(
            $bannerEditModal.find('.hidden-id').val(),
            $bannerEditModal.find('.edit-form').serializeArray()
        );
    });

    $bannerIndex.on('click', '.do-populate-form', function(){
        $bannerEditModal.find('.hidden-id').val($(this).data('id'));
        $bannerEditModal.find('.title-field').redactor('code.set', $(this).data('title'));
        $bannerEditModal.find('.caption-field').val($(this).data('caption'));
        $bannerEditModal.find('.url-field').val($(this).data('image-url'));

        banner.toggleImageField($(this).data('image'), $bannerEditModal);
    });
});

// Define Class
function Banner(urlPrefix, $container, $indexContainer)
{
    this.urlPrefix = urlPrefix; // ie. /admin/[prefix]/index
    this.$errors = $container.find('.alert-danger');
    this.$success = $container.find('.alert-success');
    this.upload = new Upload(this.urlPrefix, this.$errors, this.$success, $indexContainer);
}

Banner.prototype.create = function() {
    var $form = $bannerAddModal.find('.add-form')[0];
    this.upload.create($bannerAddModal, $form);
    this.clearCreateForm($bannerAddModal);
};

Banner.prototype.edit = function(id, data) {
    var $form = $bannerEditModal.find('.edit-form')[0];
    this.upload.edit(id, data, $bannerEditModal, $form);
};

Banner.prototype.clearCreateForm = function($modal) {
    $modal.find('.title-field').redactor('code.set', '');
    this.toggleImageField(false, $modal);
};

Banner.prototype.toggleImageField = function(imageSrc, $modal) {
    var $avatarView = $modal.find('.avatar-view');
    var $hideAfterCrop = $modal.find('.hide-after-crop');

    if (imageSrc) {
        $hideAfterCrop.hide();
        $avatarView.show();

        if ($avatarView.find('img').length > 0)
            $avatarView.find('img').attr('src', imageSrc);
        else
            $avatarView.html('<img src="' + imageSrc + '" />');
    } else {
        $hideAfterCrop.show();
        $avatarView.hide();
        $avatarView.find('img').remove();
    }
};