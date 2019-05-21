var $redirectPage = $('.redirects-page');
var $redirectForm = $redirectPage.find('.redirect-form');

$(document).ready(function(){

    $redirectPage.find('.do-filter-value').blur(function(){
        testRedirectFields();
    });

    $redirectForm.find('.btn-primary').click(function(e){
        e.preventDefault();
        if (testRedirectFields())
            $redirectForm.submit();

        return false;
    });

});

function testRedirectFields()
{
    var containsString = false;
    var notAllowed = [
        'http://',
        'www.',
        '.com',
        '.co.nz'
    ];

    $.each($('.do-filter-value'), function() {
        var $input = $(this);
        var string = $input.val();
        $input.css('border', '1px solid #ccc');

        for (var i = 0; i <= notAllowed.length; i++) {
            if (string.indexOf(notAllowed[i]) >= 0) {
                $input.css('border', '1px solid red');
                containsString = true;
            }
        }
    });

    return !containsString;
}