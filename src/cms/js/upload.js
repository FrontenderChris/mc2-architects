/*
 * UPLOAD CLASS
 * This is used to assist /images and /downloads to upload files etc
 */
function Upload(urlPrefix, $errors, $success, $indexContainer)
{
    this.urlPrefix = urlPrefix;
    this.$errors = $errors;
    this.$success = $success;
    this.$indexContainer = $indexContainer;
}

Upload.prototype.create = function($modal, $form){
    var that = this;

    that.$errors.hide();
    that.$success.hide();

    // Ensure the post size and file sizes will not break php.ini rules
    if (!this.validateSize($modal)) {
        $form.reset();
        $modal.modal('hide');
        return;
    }

    $.ajax({
        url: '/admin/' + that.urlPrefix,
        method: 'POST',
        data: new FormData($form),
        dataType:'json',
        cache:false,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.status === 'error' || response.status === 'semi-error')
                showAlert(that.$errors, response.message);

            if (response.status === 'success' || response.status === 'semi-error') {
                that.append(response.data);
                showAlert(that.$success, 'File(s) successfully uploaded.');
            }

            $form.reset();
            $modal.modal('hide');
        },
        error: function (response) {
            if (response.status === 422 && response.responseJSON) {
                // Validation errors
                showAlert($modal.find('.alert-danger'),getErrorsFromJson(response.responseJSON));
            }
            else {
                processError(response);
            }
        }
    });
};

Upload.prototype.append = function(data) {
    var that = this;

    $.each(data, function(key, value){
        $.get('/admin/' + that.urlPrefix + '/getRowHtml/' + value.id, function(response){
            that.$indexContainer.append(response);
        });
    });
};

Upload.prototype.edit = function(id, data, $modal, $form) {
    var that = this;
    var $row = $('#' + that.urlPrefix + '_' + id);

    that.$success.hide();

    $.ajax({
        url: '/admin/' + that.urlPrefix + '/' + id,
        method: 'PUT',
        data: data,
        success: function() {
            showAlert(that.$success, 'Item successfully updated.');

            $.get('/admin/' + that.urlPrefix + '/getRowHtml/' + id, function(html){
                $row.replaceWith(html);
            });

            $form.reset();
            $modal.modal('hide');
        },
        error: function (response) {
            if (response.status === 422 && response.responseJSON) {
                // Validation errors
                showAlert($modal.find('.alert-danger'),getErrorsFromJson(response.responseJSON));
            }
            else {
                processError(response);
            }
        }
    });
};

Upload.prototype.addFormRows = function(count, $modal, formRowHtml) {
    if (!count)
        count = 1;

    var id = ($modal.find('.is-row').length + 1);
    for (var i = 1; i <= count; i++) {
        $modal.find('.add-form').append(formRowHtml.replace(/{{ID}}/g, id));
        id++;
    }
};

/**
 * This function ensures the post size and file sizes will not break php.ini rules
 * If there are individual files which break the rules they will be removed (and the remaining files will be uploaded) and the user informed.
 * If the entire post size is above the ini limit, then it will not upload anything, reset the form and inform the user.
 */
Upload.prototype.validateSize = function($modal) {
    var that = this;
    var postSize = 0;
    var count = 0;
    var errorCount = 0;
    var errors = '';

    $.each($modal.find('input[type="file"]'), function(){
        var input = this;

        if (input.files && input.files[0]) {
            var files = input.files[0];
            var fileSize = parseInt((files.size / 1024)); //kbs

            if (fileSize > App.upload_max_filesize) {
                errors += 'Your file "' + files.name + '" (' + parseInt(fileSize / 1024) + 'MB) was not uploaded. It is above the maximum file size of ' + parseInt(App.upload_max_filesize / 1024) + 'MB.<br>';
                input.value = null;
                errorCount++;
            }

            postSize += fileSize;
            count++;
        }
    });

    // If any files are too big, they will be removed from the DOM so show alert to notify user
    if (errors.length > 0)
        showAlert(that.$errors, errors, 10000);

    // If the error count matches the count, then there is no data left so return false otherwise it will submit an empty form
    if (count > 0 && count === errorCount)
        return false;

    // If the post_max_size error is triggered, nothing was uploaded
    if (postSize > App.post_max_size) {
        errors = 'Your files were not uploaded. Your combined file sizes (' + parseInt(postSize / 1024) + 'MB) are above the maximum of ' + parseInt(App.post_max_size / 1024) + 'MB.';
        showAlert(that.$errors, errors, 10000);
        return false;
    }

    return true;
};