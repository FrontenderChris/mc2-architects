var $seoContainer = $('.seo-container');

$(document).ready(function(){
    $seoContainer.find('.do-copy-content').blur(function(){
        var target = $(this).data('copy-to');
        if (!$(target).val())
            $(target).val($(this).val());
    });

    $seoContainer.find('.do-show-info').click(function(){
        $(this).closest('.form-group').find('.slide-down-info').slideToggle(250);
    });
});