/* Code based on Google Map APIv3 Tutorials */
var gmapdata;
var gmapmarker;
var infoWindow;

var def_zoomval = 15;
var def_longval;
var def_latval;

function if_gmap_init(longval, latval, zoom)
{
    if (longval && latval)
    {
        def_longval = longval;
        def_latval = latval;
    }

    if (zoom)
        def_zoomval = zoom;

    var curpoint = new google.maps.LatLng(def_latval,def_longval);

    gmapdata = new google.maps.Map(document.getElementById("mapitems"), {
        center: curpoint,
        zoom: def_zoomval,
        scrollwheel: false,
        mapTypeId: 'roadmap'
    });

    gmapmarker = new google.maps.Marker({
        map: gmapdata,
        draggable:true,
        position: curpoint
    });

    infoWindow = new google.maps.InfoWindow;
    google.maps.event.addListener(gmapmarker, 'drag', function(event) {
        document.getElementById("longval").value = event.latLng.lng().toFixed(6);
        document.getElementById("latval").value = event.latLng.lat().toFixed(6);
        //gmapmarker.setPosition(event.latLng);
        if_gmap_updateInfoWindow();
    });

    google.maps.event.addListener(gmapmarker, 'dragend', function(event) {
        document.getElementById("longval").value = event.latLng.lng().toFixed(6);
        document.getElementById("latval").value = event.latLng.lat().toFixed(6);
        //gmapmarker.setPosition(event.latLng);
        if_gmap_updateInfoWindow();
    });

    google.maps.event.addListener(gmapmarker, 'click', function() {
        if_gmap_updateInfoWindow();
        infoWindow.open(gmapdata, gmapmarker);
    });

    document.getElementById("longval").value = def_longval;
    document.getElementById("latval").value = def_latval;

    return false;
}

function if_gmap_loadpicker()
{
    var longval = document.getElementById("longval").value;
    var latval = document.getElementById("latval").value;

    if (longval.length > 0)
    {
        if (isNaN(parseFloat(longval)) == true)
        {
            longval = def_longval;
        }
    }
    else
    {
        longval = def_longval;
    }

    if (latval.length > 0)
    {
        if (isNaN(parseFloat(latval)) == true)
        {
            latval = def_latval;
        }
    }
    else
    {
        latval = def_latval;
    }

    var curpoint = new google.maps.LatLng(latval,longval);

    gmapmarker.setPosition(curpoint);
    gmapdata.setCenter(curpoint);
    //gmapdata.setZoom(zoomval);

    if_gmap_updateInfoWindow();
    return false;
}

function if_gmap_updateInfoWindow()
{
    infoWindow.setContent("Longitude: "+ gmapmarker.getPosition().lng().toFixed(6)+"<br>"+"Latitude: "+ gmapmarker.getPosition().lat().toFixed(6));
}

function show_address_on_map(address)
{
    var geocoder = new google.maps.Geocoder;

    geocoder.geocode({
        address: address,
        componentRestrictions: {country: 'NZ'},
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK)
        {
            gmapdata.setCenter(results[0].geometry.location);
            gmapmarker.setPosition(results[0].geometry.location);

            document.getElementById("longval").value = results[0].geometry.location.lng().toFixed(6);
            document.getElementById("latval").value = results[0].geometry.location.lat().toFixed(6);
        }
        else
        {
            window.alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
