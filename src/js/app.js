// Remove blue highlight on click
document.addEventListener("touchstart", function(){}, true);

var $subscribeContainer = $('.subscribe-container');

$(document).ready(function(){
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
    /* ----------------------------------------------------------------------------------- */
    $subscribeContainer.find('#subscribe-email').keydown(function(e){
        if (e.keyCode == 13) {
            e.preventDefault();
            doSubscribe();
            return false; 
        }
    });

    $subscribeContainer.find('.do-subscribe').click(function(){
        doSubscribe();
    });
    /* ----------------------------------------------------------------------------------- */
});

function doSubscribe()
{
    var email = $subscribeContainer.find('#subscribe-email').val();

    if (email) {
        $.ajax({
            url: '/subscribe',
            method: 'POST',
            data: {email: email},
            success: function(response){
                $subscribeContainer.find('.subscribe-response').remove();
                if (response.status == 'success') {
                    $subscribeContainer.fadeOut(250);
                    setTimeout(function(){
                        $subscribeContainer.html('<p class="subscribe-response">You have been successfully subscribed.</p>').fadeIn(250);
                    }, 250);
                }
                else {
                    $subscribeContainer.append('<p class="subscribe-response" style="color: red; font-size: 14px;">' + response.error + '</p>');
                }
            }
        });
    }
}