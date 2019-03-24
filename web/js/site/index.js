
function removeData(chart) {
    chart.data.labels = [];
    chart.data.datasets.forEach((dataset) => {
        dataset.data = [];
    });
    chart.update();
}

function reloadVotos() {
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
            var postulaciones = [];
            var votos = [];
            if(response.success)
            {
                response.data.forEach(function (element) {
                    chart.data.labels.push(element.name);
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.push(element.vote);
                    });
                });

                chart.options = config;
                chart.update();
            }
            else {
                $.alert('No sea ha encontrado ninguna información.!');
            }
        },
        error: function(data) {
            $.alert('No sea ha encontrado ninguna información.!');
        }
    });

}

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
                min: 0
            },
            display: true,
            scaleLabel: {
                display: true,
                labelString: 'Votos'
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
                labelString: 'Candidatos'
            },
        }]
    }
};

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

$(document).ready(function () {
    init();
    reloadVotos();
    // stop watch
    setInterval(reloadVotos, 30000);
});