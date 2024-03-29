<section id="site-loader">
    <div class="loader"></div>
</section>


<style>
    #site-loader {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-color: white;
        z-index: 9999999999999999999;
        visibility: visible;
        opacity: 1;
        -webkit-transition: all .5s ease-in-out;
                transition: all .5s ease-in-out;
    }

    #site-loader .loader {
        position: absolute;
        top: calc(50% - 100px);
        left: calc(50% - 100px);
        bottom: 0;
        width: 200px;
        height: 200px;
        background-image: url("/images/logo.png");
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        -webkit-animation: loader_fade infinite 1s;
                animation: loader_fade infinite 1s;
    }

    #site-loader.hide {
        visibility: hidden;
        -webkit-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
        opacity: 0;
    }

    #site-loader.no-loader {
        display: none;
    }

    @-webkit-keyframes loader_rotate {
        0% {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
                    transform: rotate(359deg);
        }
    }

    @keyframes loader_rotate {
        0% {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
                    transform: rotate(359deg);
        }
    } 

    @-webkit-keyframes loader_fade {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes loader_fade {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
        100% {
            opacity: 1;
        }
    }    
</style>

<script>
    if (location.pathname == '/') { 
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("site-loader").classList.add('hide');
        });
    } else {
        document.getElementById("site-loader").classList.add('no-loader');
    }

    /* 
    If you want the loader to be on every page,replace with this:

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("site-loader").classList.add('hide');
    });  
    */
</script>
