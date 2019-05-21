var $body = $('body');
var dateFormat = 'dd M yy';

$(document).ready(function(){
    /*
     * FOUC - Flash of unloaded content
     * Only display the content when the document is ready. This prevents incomplete
     * funcionality and unstyled content being displayed.
     */
    $(".fouc").fadeIn(250);
    /* ---------------------------------------------------------------------------------------- */
    /*
     * LAZYLOAD IMAGES
     * Using the jquery.unveil plugin images with the class "lazyload" will
     * be lazy loaded. Some special calls are used to show tabbed images etc.
     * See http://luis-almeida.github.io/unveil/
     */
    $(".lazyload").unveil();
    /* ---------------------------------------------------------------------------------------- */
    /*
    * CSRF PROTECTION
    * This is used to add a CSRF token to all AJAX requests (pulled from a meta tag)
    * otherwise for DELETE requests etc we get an error
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     * GLOBAL ERROR HANDLING
     * 1. If users are not logged in, refresh the page. Further error handling to be added.
     * 2. If we catch a CSRF TokenMismatchException this can be remedied by reloading page.
     */
    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        if (jqxhr.status == 401) {
            location.reload();
        }
        else if (jqxhr.status == 500 && jqxhr.responseText.indexOf('TokenMismatchException') > -1) {
            location.reload();
        }
        else {
            // If we get an error, log this for further debugging
            console.log(jqxhr);
        }
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
    * TABBING CONTENT
    * Give the tab the do-show-content class
    * add data-show=".your-class-or-id" attribute for which div to show
    * add data-hide=".your-class-or-id" attribute for which div to hide
    */
    var $doShowContent = $('.do-show-content');
    $doShowContent.on('click', function(){
        $('.tab-content').hide();
        if ($(this).data('show'))
            $($(this).data('show')).show();

        $doShowContent.parent().removeClass('active');
        $(this).parent().addClass('active');

        $(window).trigger("lookup"); // Force the image lazyloader
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
    * SLUGIFY CONTENT
    * Give a title/name text field the class "do-slugify" and it will find the class="is-slug" text
    * field on the page and automatically convert itself into a slug
    */
    var $doSlugify = $('.do-slugify');
    var $slugField = $('.is-slug');
    $doSlugify.keyup(function(){
        addSlug($(this).val(), $slugField);
    });

    $doSlugify.blur(function(){
        addSlug($(this).val(), $slugField);
    });

    $slugField.blur(function(){
        addSlug($(this).val(), this);
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
    * FANCY BUTTON
    * This code will make regular buttons display the loading... text on click
    * It gives the user an instant response if they have a slower browser
    * To implement this:
    <button type="button" class="btn btn-primary loading-btn" autocomplete="off" data-url="{{ route('admin.products.create') }}">
    Create Product
    </button>
    * Note: You may add data-loading-text="Loading..." if you want to customise the HTML
    */
    $('.loading-btn').on('click', function () {
        var text = 'Loading...';
        if ($(this).data('loading-text'))
            text = $(this).data('loading-text');

        if (typeof $(this).attr('value') !== typeof undefined && $(this).attr('value') !== false)
            $(this).val(text);
        else
            $(this).html(text);

        if ($(this).data('url')) {
            window.location = $(this).data('url');
            return;
        }

        // Reset btn after 3 seconds
        if ($(this).data('original')) {
            var selector = $(this);
            setTimeout(function(){
                resetBtn(selector);
            }, 3000);
        }
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
    * DATEPICKER
    * See jQuery UI docs
    */
    $('.has-datepicker').datepicker({
        dateFormat: dateFormat
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
    * REQUIRED FIELDS
    * Append a * to the end of all labels with the class "required"
    */
    $('.required').append('<span> *</span>');
    /* ---------------------------------------------------------------------------------------- */
    /*
    * DELETE RECORDS USING AJAX
    * Give the detete button a class of "do-delete-row" and the following attribute:
    * data-target="{{ route('your.route.name') }}"
    */
    $body.on('click', '.do-delete-row', function(){
        if (deleteRow($(this).data('target'))) {
            var $tableRow = $(this).closest('tr');
            if ($tableRow.length) {
                $tableRow
                    .children('td')
                    .wrapInner('<div class="td-slider" />')
                    .children(".td-slider")
                    .slideUp(300);
                setTimeout(function(){
                    $tableRow.remove();
                }, 400);
            } else {
               var $row = $(this).closest('.row');
                $row.slideUp(300);
                setTimeout(function(){
                    $row.remove();
                }, 400);
            }
        }
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * LINK BUTTONS
     * To make a button go to a URL just add the data-url attribute with the target URL
     */
    $('button[data-url]').click(function(){
        window.location = $(this).data('url');
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * SORTABLE
     * This method makes the .sortable class automatically sortable.
     * You need to have the data-sort-url="" attribute on your sortable element so the AJAX
     * knows where to send the info.
     */
    var $sortable = $('.sortable');
    $.each($sortable, function(key, value){
        var url = $(this).data('sort-url');

        $(this).sortable({
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                saveSortOrder(data, url);
            }
        });
        $(this).disableSelection();
        $(this).sortable({cancel: '.table-heading'});
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * INSTANT SEARCHING
     * Give the ability to instantly search through the data-search="" attributes as you type
     * Give the search bar the "do-search" class and a data-search-target=".your-container" attribute
     * Ensure your rows within .your-container have data-search="search words"
     */
    var $doSearch = $('.do-search');
    $body.on('keyup', '.do-search', function(){
        doSearch(
            $(this).data('search-target'),
            $(this).val()
        );
    });
    $doSearch.focus();

    listenSearchCrossClicks();

    // On php search, refresh the page when clicking the X icon
    $('.search-php').find('[data-clear-input]').click(function(){
        window.location = $(this).data('location');
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * REDACTOR II WYSIWYG
     * CLASSES: has-redactor OR has-redactor-basic
     * If custom settings are required you can add them in a data-settings="" attribute on your textarea
     * ie.
     {{ Form::textarea('data[hero_content]', null, ['class' => 'form-control has-redactor', 'rows' => 3, 'data-settings' => json_encode([
     'buttons' => ['bold', 'italic', 'underline'],
     'minHeight' => '0',
     'plugins' => [],
     ])]) }}
     * OR
     * ie. {{ Form::textarea('content', null, ['class' => 'form-control has-redactor', 'data-settings' => '{"buttons": ["format"]}']) }}
     * OR
     * <textarea class="has-redactor" data-settings='{"setting": "value", "setting2": "value2"}'></textarea>
     */

    var $hasRedactor = $('.has-redactor');  // Full (normal) version
    // The below versions should be used with the PHP helper title() when echoing on frontend
    var $hasRedactorBasic = $('.has-redactor-basic'); // Basic version with b/i/u
    var $hasRedactorInline = $('.has-redactor-inline'); // This version should only be used for single line elements ie. titles

    var redactorSettings = {
        plugins: ['imagemanager', 'filemanager', 'source', 'alignment', 'video', 'fullscreen', 'table'],
        minHeight: 300,

        imageUpload: '/admin/redactor/saveImage?_token=' + App.csrf_token,
        imageManagerJson: '/admin/redactor/getImages',

        fileUpload: '/admin/redactor/saveFile?_token=' + App.csrf_token,
        fileManagerJson: '/admin/redactor/getFiles',

        callbacks: {
            imageUploadError: function(json)
            {
                alert(json.error);
            },
            fileUploadError: function(json)
            {
                alert(json.error);
            }
        }
    };
    $.each($hasRedactor, function(){
        var that = $(this);
        if (that.data('settings'))
            $.extend(redactorSettings, that.data('settings'));

        that.redactor(redactorSettings);
    });
    /*---------------------------------------------------------------*/
    var redactorBasicSettings = {
        buttons: ['bold', 'italic', 'underline'],
        minHeight: 0
    };
    $.each($hasRedactorBasic, function(){
        var that = $(this);
        if (that.data('settings'))
            $.extend(redactorBasicSettings, that.data('settings'));

        $(this).redactor(redactorBasicSettings);
    });
    /*---------------------------------------------------------------*/
    var redactorInlineSettings = {
        buttons: ['bold', 'italic', 'underline'],
        minHeight: 0,
        air: true,
        callbacks: {
            enter: function(e) {
                return false;
            },
            blur: function() {
                this.code.set(this.clean.stripTags(this.code.get(), '<p>'));
            },
            change: function() {
                var $textarea = $(this.core.textarea());
                if ($textarea.hasClass('do-slugify'))
                    addSlug(this.code.get(), $slugField);
            }
        }
    };
    $.each($hasRedactorInline, function(){
        var that = $(this);

        // Give parent a class for the CSS
        that.parent().addClass('redactor-inline');

        if (that.data('settings'))
            $.extend(redactorInlineSettings, that.data('settings'));

        $(this).redactor(redactorInlineSettings);
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * TOGGLE VISIBILITY/FEATURED BTNS
     */
    $('.do-toggle-visibility').click(function(){
        var $btn = $(this);
        toggleVisibility($btn);
    });

    $('.do-toggle-featured').click(function(){
        var $btn = $(this);
        toggleFeatured($btn);
    });
    /* ---------------------------------------------------------------------------------------- */
    /*
     * SELECT2 PLUGIN - AUTO INSTANTIATE
     */
    $('.has-tagged-select2').select2({
        tags: true
    });
    /* ---------------------------------------------------------------------------------------- */
});

function addSlug(value, targetId)
{
    var slug = convertToSlug(value);
    $(targetId).val(slug);
}

function convertToSlug(text)
{
    return text
        .toLowerCase()
        .replace(/<(?:.|\n)*?>/gm, '')
        .replace(/[^\w -]+/g,'')
        .replace('nbsp', '')
        .replace(/ +/g,'-');
}

function deleteRow(url)
{
    var check = confirm('Are you sure you want to delete this item?');
    if (check) {
        $.ajax({
            url: url,
            method: 'DELETE',
            success: function(response){
                if (response.status === 'error')
                    alert(response.msg);
            },
            error: function (response) {
                processError(response);
            }
        });

        return true;
    }

    return false;
}

function toggleVisibility($btn)
{
    $.ajax({
        url: $btn.data('target'),
        method: 'POST',
        success: function(response) {
            if (response.status === 'success')
                $btn.find('.glyphicon').toggleClass('glyphicon-eye-open glyphicon-eye-close');
        }
    });
}

function toggleFeatured($btn)
{
    $.ajax({
        url: $btn.data('target'),
        method: 'POST',
        success: function(response) {
            if (response.status === 'success')
                $btn.find('.glyphicon').toggleClass('glyphicon-star glyphicon-star-empty');
        }
    });
}

function resetBtn(selector)
{
    var text = $(selector).data('original');

    if (typeof $(selector).attr('value') !== typeof undefined && $(selector).attr('value') !== false)
        $(selector).val(text);
    else
        $(selector).html(text);
}

function saveSortOrder(data, url)
{
    var $downloadError = $('.download-errors');
    $downloadError.hide();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.status !== 'success') {
                $downloadError.html(response.message);
                $downloadError.fadeIn(250);
            }
        },
        error: function (response) {
            processError(response);
        }
    });
}

function processError(response) {
    if (response.status === 401)
        location.reload();

    if (response.status === 500)
        alert(response.statusText);
}

function showAlert(selector, message, duration)
{
    if (!duration)
        duration = 6000;

    var $alert = $(selector);
    $alert.html(message);
    $alert.fadeIn(250);

    setTimeout(function(){
        $alert.slideUp(250).html('');
    }, duration);
}

function doSearch(target, search)
{
    var $target = $(target);

    if (search && search !== '') {
        $target.find('[data-search]').hide();
        $target.find('[data-search*="' + search.toLowerCase() + '"]').show();
    } else {
        $target.find('[data-search]').show();
    }
}

function listenSearchCrossClicks()
{
    // Listen for cross clicks, when clicked empty input and redo search
    Array.prototype.forEach.call(document.querySelectorAll('.clearable-input'), function(el) {
        el.addEventListener('click', function(e) {
            e.target.previousElementSibling.value = '';

            var $input = $(e.target).parent().find('.do-search');
            doSearch(
                $input.data('search-target'),
                $input.val()
            );
        });
    });
}

function initHasSelect2($selector)
{
    $selector.select2({
        placeholder: $selector.data('placeholder'),
        minimumResultsForSearch: 3
    });
}

function getErrorsFromJson(json)
{
    var errors = '';
    $.each(json, function(key, value){
        errors += value[0] + '<br>';
    });

    return errors;
}