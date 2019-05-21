$(document).ready(function(){
    var $contactContainer = $('.contact-form');

    $contactContainer.find('.do-search-address').click(function(){
        var address = $('.map-search input').val();
        show_address_on_map(address);
    });

    $contactContainer.find('.address-input').keypress(function(e){
        var key = e.which;
        if (key == 13)
        {
            var address = $('.map-search input').val();
            show_address_on_map(address);
            return false;
        }
    });

    $contactContainer.find('.do-push-address').blur(function(){
        show_address_on_map($(this).val());
    });
});