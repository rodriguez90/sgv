var interval = null;

var timeOut = 60000;

// $.xhrPool = [];
// $.xhrPool.abortAll = function() {
//     $(this).each(function(idx, jqXHR) {
//         jqXHR.abort();
//     });
//     $.xhrPool = [];
// };
//
// $.ajaxSetup({
//     beforeSend: function(jqXHR) {
//         $.xhrPool.push(jqXHR);
//     },
//     complete: function(jqXHR) {
//         var index = $.xhrPool.indexOf(jqXHR);
//         if (index > -1) {
//             $.xhrPool.splice(index, 1);
//         }
//     }
// });

var chart = null;
var config = {
    responsive: true,
    title: {
        display: true,
        text: 'Votos por Postulación'
    },
    scales: {
        xAxes: [{
            type: 'linear',
            ticks: {
                min: 0,
                max: 100,
                // Include a dollar sign in the ticks
            },
            display: true,
            scaleLabel: {
                display: true,
                labelString: 'Porciento de Votos'
            },
        }],
        yAxes: [{
            ticks: {
                stepSize: 5,
                // callback: function(value, index, values) {
                //     console.log('values', values);
                //     return value + ' %';
                // }
            },
            display: true,
            type: 'category',
            scaleLabel: {
                display: true,
                labelString: 'Candidatos'
            },
        }]
    },
    tooltips: {
        callbacks: {
            title: function (tooltipItem, data) {
                return "Candidato: " + data.labels[tooltipItem[0].index];
            },
            footer: function (tooltipItem, data) {
                var voto = dataMap.get(data.labels[tooltipItem[0].index]);
                return "Votos: " + voto;
            },
            label: function(tooltipItems, data) {
                return "Porciento: " + tooltipItems.xLabel + ' %';
            },

        }
    }
};

// Define a plugin to provide data labels
Chart.plugins.register({
    afterDatasetsDraw: function(chart) {
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

var dataMap = new Map();

function removeData(chart) {
    chart.data.labels = [];
    chart.data.datasets.forEach((dataset) => {
        dataset.data = [];
    });
    chart.update();
}

function fetchVotos() {
    removeData(chart);

    var canton = $("#canton_select2").val();
    var recinto = null;
    if($("#recinto_select2").val() !== '-' )
    {
        recinto = $("#recinto_select2").val();
    }

    var dignidad = $("#dignidad_select2").val();

    $.ajax({
        url: homeUrl + 'site/votospostulacion',
        data: {
            canton: canton,
            recinto: recinto,
            dignidad: dignidad
        },
        type: "GET",
        success: function (response) {
            if(response.success)
            {
                response.data.forEach(function (element) {
                    dataMap.set(element.name, element.vote);
                    chart.data.labels.push(element.name);
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.push(element.porciento);
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
                label: 'Votos',
                data: [],
            }]
        },

        // Configuration options go here
        options: config
    });
}

function renderVotoChart(data) {
    var ctx = document.getElementById("postulacion_voto_chart").getContext('2d');

    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'horizontalBar',

        // The data for our dataset
        data: {
            labels: data.postulaciones,
            datasets: [{
                label: 'Votos por Postulación',
                // backgroundColor: 'rgb(255, 99, 132)',
                // borderColor: 'rgb(255, 99, 132)',
                data: data.votos,
            }]
        },

        // Configuration options go here
        options: {}
    });
}

function fetchTotales(){

    $.ajax({
        url: homeUrl + 'site/elecciones-totales',
        type: "GET",
        success: function (response) {
            if(response.success)
            {
                $('#totalElectores').html(response.data.totalElectores);
                $('#totalVotos').html(response.data.totalVotos);
                $('#totalVotosNulos').html(response.data.totalVotosNulos);
                $('#totalVotosBlancos').html(response.data.totalVotosBlancos);
            }
        },
        error: function(data) {
            // $.alert('No sea ha encontrado ninguna información.!');
        }
    });

}

function fetchData() {
    clearInterval(interval);

    fetchTotales();
    fetchVotos();

    interval = setInterval(fetchData, timeOut);
}

$(document).ready(function () {
    init();
    fetchData();
    // stop watch
    interval = setInterval(fetchData, timeOut);
});

// $.xhrPool and $.ajaxSetup are the solution
