var $contactContainer = $('.contact-form');
var $pageChildSortable = $('.pages-child-sortable');

$(document).ready(function(){
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

    $.each($pageChildSortable, function(key, value){
        var url = $(this).data('sort-url');
        $(this).sortable({
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                saveSortOrder(data, url);
            },
            connectWith: ".pages-child-sortable"
        });
        $(this).disableSelection();
        $(this).sortable({cancel: '.table-heading'});
    });

    $body.on('click', '.do-delete-page', function(){
        if (deleteRow($(this).data('target'))) {
            var $child = $(this).closest('.child-page');

            if ($child.length > 0)
                var $row = $child;
            else
                $row = $(this).closest('.row');

            $row.slideUp(300);
            setTimeout(function(){
                $row.remove();
            }, 400);
        }
    });
});