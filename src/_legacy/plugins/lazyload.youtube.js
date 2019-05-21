// Document Ready Starts
$(document).ready(function () {

    // Lazy Load Youtube Videos        
    (function () {
        var v = document.querySelectorAll(".youtube-player");
        for (var n = 0; n < v.length; n++) {
            var p = document.createElement("div");
            p.className = "youtube-bg";
            p.style.backgroundImage = 'url('+labnolBGThumb(v[n].getAttribute("data-id"))+')';
            p.innerHTML = labnolPlyBtn();
            p.onclick = labnolIframe;
            v[n].appendChild(p);
        }
    })();

    function labnolPlyBtn() {
        return '<div class="play-button"></div>';
    }
    function labnolBGThumb(id) {
        return '//i.ytimg.com/vi/' + id + '/hqdefault.jpg';
    }

    function labnolIframe() {
        var iframe = document.createElement("iframe");
        iframe.setAttribute("src", "//www.youtube.com/embed/" + this.parentNode.getAttribute("data-id") + "?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&controls=2&showinfo=0&fs=1");
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "true");
        iframe.setAttribute("id", "youtube-iframe");
        this.parentNode.replaceChild(iframe, this);
    }

});
// Document Ready Ends