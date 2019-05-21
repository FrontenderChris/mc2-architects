var $categoryChildSortable = $('.category-child-sortable');

$(document).ready(function(){
    $.each($categoryChildSortable, function(key, value){
        var url = $(this).data('sort-url');
        $(this).sortable({
            // If an element is larger than the top or bottom element, it can't be sorted to the top or bottom.
            // Removing containment:parent will fix it if required, but I prefer to keep it on since it prevents items being dragged all over the screen.
            // NB: This was meant to be fixed in jquery-ui v12 but it didn't seem to fix the issue.
            containment: 'parent',
            tolerance: 'pointer',
            items: '> .child-page',
            update: function(event, ui) {
                var data = $(this).sortable('serialize');
                saveSortOrder(data, url);
            }
        });
        $(this).disableSelection();
        $(this).sortable({cancel: '.table-heading'});
    });
});