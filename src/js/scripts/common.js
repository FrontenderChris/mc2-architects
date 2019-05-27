$(document).ready(function() {


    // #############################################
    //Form Validation :::
    $('.validate-form').each(function() {
        $(this).validate({
            submitHandler: function(form) {
                form.submit();
            },
            rules: {
                required: true
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parents('.form-field'));
            },
            highlight: function(element, errorClass, validClass) {
                if (element.type === 'radio') {
                    this.findByName(element.name).parents('.form-field').addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).parents('.form-field').addClass(errorClass).removeClass(validClass);
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                if (element.type === 'radio') {
                    this.findByName(element.name).parents('.form-field').removeClass(errorClass).addClass(validClass);
                } else {
                    $(element).parents('.form-field').removeClass(errorClass).addClass(validClass);
                }
            }
        });
    });


    // #############################################
    //Custom Select Dropdown && Multiselect :::
    
    $(function() {
        $('.custom-select-dropdown').selectric();
    });


    // #############################################
    //Lightbox Initiations ::::
    $('.open-popup-link').magnificPopup({
        type:'inline',
        showCloseBtn: true,
        closeOnBgClick: true,
        removalDelay: 300,
        mainClass: 'mfp-zoom-in',
        midClick: true
    });

    $('.lightbox-manual-close-trigger').click(function(event) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    // #############################################
    // TABS

    $('.js-tab-triggers a').on('click', function(e) {
        e.preventDefault();
        $('.js-tab-triggers a').not(this).removeClass('active');
        $(this).addClass('active');
        var getTarget = $(this).attr('href');
        $('.tab-content').not(getTarget).hide();
        $(getTarget).show();
    });


    // #############################################
    //footer animation

    $(window).scroll(function(event) {

        if ( $('.site-footer').visible(true)) {
            $('.site-footer').addClass("come-in"); 
        }

        if ( $('.title-container h1').visible(true)) {
            $('.title-container h1').addClass("border"); 
        }


        if ( $('.hero-container') ) {

            var scroll = $(window).scrollTop();
            var os = $('.hero-container').offset().top; 
            var ht = $('.hero-container').height();
            
            if(scroll > ht){
                $('.hamburger, .lang-btn').addClass('color-change');
            }else {
                $('.hamburger, .lang-btn').removeClass('color-change');
            }
            
        };
    
    });

    // #############################################


    $(".js-scroll-down").click(function (){
        disable_scroll();
        $('html, body').stop().animate({scrollTop: $(".title-container").offset().top - 80}, 1500, function() {
            disable_scroll();
        });
    });

    // #############################################
    //Gallery Popup

    $('.img-container').magnificPopup({
        delegate: '.image img',
        type: 'image',
        gallery:{
            enabled:true
        }
    });

});


$(function() {  
    $("body").niceScroll();
});


// #############################################
//If visible on screen function ::: 

(function($) {

    $.fn.visible = function(partial) {
        
        var $t            = $(this),
            $w            = $(window),
            viewTop       = $w.scrollTop(),
            viewBottom    = viewTop + $w.height(),
            _top          = $t.offset().top,
            _bottom       = _top + $t.height(),
            compareTop    = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;
        
        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };
    
})(jQuery);

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = [37, 38, 39, 40];

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function keydown(e) {
    for (var i = keys.length; i--;) {
        if (e.keyCode === keys[i]) {
            preventDefault(e);
            return;
        }
    }
}

function wheel(e) {
  preventDefault(e);
}

function disable_scroll() {
  if (window.addEventListener) {
      window.addEventListener('DOMMouseScroll', wheel, false);
  }
  window.onmousewheel = document.onmousewheel = wheel;
  document.onkeydown = keydown;
}

function disable_scroll() {
    if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = document.onkeydown = null;  
}


// #############################################
//Toggle HTML function ::: 

$.fn.toggleHTML = function(t1, t2) {
    if (this.html() == t1) this.html(t2);
    else this.html(t1);
    return this;
};


// #############################################
//Main Menu ::: 
function slideMenu(action){ 
    var $menu = $('#mobile-menu') 
    if (!action) { toggle(); return }
    if (action == "open") { open(); return }
    if (action == "close") { close(); return }

    function open(){
        $("body").addClass('open-menu');
        $menu.attr('status', 'open');
    }
    function close(){
        $("body").removeClass('open-menu');
        $menu.attr('status', 'closed');
    }
    function toggle(){
        var status =  $menu.attr('status');
        $('.hamburger').toggleClass('open');
        if (status == "open"){ close(); return }
        if (status == "closed"){ open(); return }
    }
}

$('#mobile-menu li').each(function(){
        $(this).has("ul").addClass('mobile-menu-parent');
});

$( ".mobile-menu-parent .icon" ).on("click", function(){
    $(this).siblings('ul').slideToggle(150);
});

//prevent slide up
$(".mobile-menu-parent").on("click", "ul", function(event){
    event.stopPropagation()
})

// #############################################
// Header Highlighter :::
$(document).ready(function() {
    var headerHref = "#site-header";
    var mobileHref = "#mobile-menu";
    var myURL = "/" + location.pathname.split('/')[1];

    $(headerHref + ' li').each(function(){
        if ($(this).find('a').attr('href') == myURL) {
            $(this).find('a').addClass("selected")
            return
        }
    })

    $(mobileHref + ' li').each(function(){
        if ($(this).find('a').attr('href') == myURL) {
            $(this).find('a').addClass("selected")
            return
        }
    })
});



