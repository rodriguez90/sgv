var interval = null;

var timeOut = 60000;

var chart = null;
var config = {
    responsive: true,
    title: {
        display: true,
        text: 'Actas por Canton'
    },
    scales: {
        xAxes: [{
            type: 'linear',
            ticks: {
                min: 0,
            },
            display: true,
            scaleLabel: {
                display: true,
                labelString: 'Cantidad de Actas Registradas'
            },
        }],
        yAxes: [{
            ticks: {
                stepSize: 5,
            },
            display: true,
            type: 'category',
            scaleLabel: {
                display: true,
                labelString: 'Cantones'
            },
        }]
    }
};

// Define a plugin to provide data labels
Chart.plugins.register({
    afterDatasetsDraw: function(chart) {
        if($(chart.ctx.canvas).attr('id') == 'w0') return;
        var ctx = chart.ctx;

        chart.data.datasets.forEach(function(dataset, i) {
            var meta = chart.getDatasetMeta(i);
            if (!meta.hidden) {
                meta.data.forEach(function(element, index) {
                    // Draw the text in black, with the specified font
                    ctx.fillStyle = 'rgb(0, 0, 0)';

                    var fontSize = 10;
                    var fontStyle = 'normal';
                    var fontFamily = 'Source Sans Pro';
                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                    // Just naively convert to string for now
                    var dataString = dataset.data[index].toString();

                    // Make sure alignment settings are correct
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    var padding = 0;
                    var position = element.tooltipPosition();
                    ctx.fillText(dataString, position.x + 10, position.y);
                });
            }
        });
    }
});

function removeData(chart) {
    chart.data.labels = [];
    chart.data.datasets.forEach((dataset) => {
        dataset.data = [];
    });
    chart.update();
}

function fetchRecintoActas() {
    removeData(chart);

    var canton = $("#canton_select2").val();
    var recinto = null;
    var tipoJunta = null;
    if($("#junta_select2").val() !== '' )
    {
        tipoJunta = $("#junta_select2").val();
    }

    var dignidad = $("#dignidad_select2").val();

    $.ajax({
        url: homeUrl + 'site/recintoactas',
        data: {
            canton: canton,
            recinto: recinto,
            dignidad: dignidad,
            tipoJunta: tipoJunta
        },
        type: "GET",
        success: function (response) {
            var postulaciones = [];
            var votos = [];
            if(response.success)
            {
                var totales =  response.data.totales;
                var rentintoActas = response.data.rentintoActas;

                $('#totalRecintos').html(totales.totalRecintos);
                $('#totalJunta').html(totales.totalJunta);
                $('#totalActas').html(totales.totalActas);
                $('#totalPostulacion').html(totales.totalPostulacion);

                rentintoActas.forEach(function (element) {
                    chart.data.labels.push(element.name);
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.push(element.cantidad);
                    });
                });

                chart.options = config;
                chart.update();
            }
            else {
                // $.alert('No sea ha encontrado ninguna información.!');
            }
        },
        error: function(data) {
            // $.alert('No sea ha encontrado ninguna información.!');
        }
    });

}

function init() {
    var ctx = document.getElementById("postulacion_voto_chart").getContext('2d');
    chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'horizontalBar',

        // The data for our dataset
        data: {
            labels: [],
            datasets: [{
                label: 'Actas',
                data: [],
            }]
        },

        // Configuration options go here
        options: config
    });
}

function fetchData() {
    clearInterval(interval);
    fetchRecintoActas();
    interval = setInterval(fetchData, timeOut);
}

$(document).ready(function () {
    init();
    fetchData();
    setInterval(fetchData, timeOut);

});