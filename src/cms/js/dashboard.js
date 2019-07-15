Chart.defaults.global.responsive = true;

$(document).ready(function(){
    doCircliful();
});

function doCircliful()
{
    $.each($('.do-circliful'), function(){
        $(this).circliful({
            foregroundBorderWidth: 15,
            backgroundBorderWidth: 15,
            foregroundColor: '#15a2fc',
            percentageTextSize: 35,
            percent: $(this).data('percent'),
            text: $(this).data('text')
        });
    });
}

function makeViewsChart(labels, visitors, pageViews)
{
    var ctx = document.getElementById("pageViewsChart").getContext("2d");
    var data = {
        labels: labels,
    datasets: [{
        label: 'Visitors',
        fillColor: "rgba(21,162,252,0.2)",
        strokeColor: "rgba(21,162,252,1)",
        pointColor: "rgba(21,162,252,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: visitors
}/*,
     {
     label: 'Page Views',
     fillColor: "rgba(45,249,22,0.2)",
     strokeColor: "rgba(220,220,220,1)",
     pointColor: "rgba(220,220,220,1)",
     pointStrokeColor: "#fff",
     pointHighlightFill: "#fff",
     pointHighlightStroke: "rgba(220,220,220,1)",
     data: pageViews
     }*/]
};
    return new Chart(ctx).Line(data);
}

function makeTrafficSourceChart(direct, organic, referral)
{
    var ctx = document.getElementById('trafficSourceChart').getContext("2d");
    var data = [
        {
            value: direct,
            color:"#15A2FC",
            highlight: "#D0ECFE",
            label: "Direct"
        },
        {
            value: organic,
            color: "#15A2FC",
            highlight: "#D0ECFE",
            label: "Organic"
        },
        {
            value: referral,
            color: "#15A2FC",
            highlight: "#D0ECFE",
            label: "Referral"
        }
    ];

    return new Chart(ctx).Pie(data);
}

function makeDevicesChart(desktop, mobile, tablet)
{
    var ctx = document.getElementById('devicesChart').getContext("2d");
    var data = [
        {
            value: desktop,
            color:"#15A2FC",
            highlight: "#D0ECFE",
            label: "Desktop"
        },
        {
            value: mobile,
            color: "#15A2FC",
            highlight: "#D0ECFE",
            label: "Mobile"
        },
        {
            value: tablet,
            color: "#15A2FC",
            highlight: "#D0ECFE",
            label: "Tablet"
        }
    ];

    return new Chart(ctx).Pie(data);
}