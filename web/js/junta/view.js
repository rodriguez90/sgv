
var actaMap = new Map();

function totalVotos(acta) {
    var table = $('#table-acta-' + acta).DataTable();

    var total = 0;

    table
        .rows( )
        .data()
        .each( function ( voto, index ) {
            total += voto.vote;
        });

    total += getValueFromActa(acta, 'null_vote') +  getValueFromActa(acta, 'blank_vote');

    return total;
}

function getValueFromActa(acta, valueName) {
    var result = 0;
    if($("#Actas_" + String(acta) + "_" + valueName).length)
        result = parseInt($("#Actas_" + String(acta) + "_" + valueName).prop('value'));
    return result;
}

function actualizaTotalVotos(total, acta, classValue) {
    if($('#totalVotos_' + acta).length)
    {
        $('#totalVotos_' + acta).removeAttr('class').attr('class', classValue);
        $('#totalVotos_' + acta).html(total);
    }
}

function validarVotos(total, acta) {
    var cantidadElectores = parseInt(getValueFromActa(acta, 'count_elector'));
    var cantidadVotantes = parseInt(getValueFromActa(acta, 'count_vote'));

    console.log('validando votos para acta ', acta);
    console.log('total', total);
    console.log('cantidadElectores', cantidadElectores);
    console.log('cantidadVotantes', cantidadVotantes);


    var result = {
        'error': false,
        'msg': ''
    };

    if(cantidadVotantes > cantidadElectores)
    {
        result.msg = 'La cantidad de votantes no debe ser superior a la cantidad de electores';
        result.error = true;
        return result;
    }

    if(total > cantidadVotantes || total > cantidadElectores )
    {
        result.msg = 'El total de votos no debe ser superior a la cantidad de electores y de votantes';
        result.error = true;
        return result;
    }

    console.log('result', result);

    return result;
}

function reloadVotos(){
    var loadingHtml = '<div class="overlay">' + '<i class="fa fa-circle-o-notch fa-spin"></i>' + '</div>';

    $("#container").html(loadingHtml);
    $.ajax({
        url: homeUrl + "/junta/generar-actas",
        data:{
            "canton":cantonId,
            "recinto":recintoId,
            "junta": modelId
        },
        success:function (response) {
            var actas = response.data;
            var tabsHtml = generateTabsHtml(actas);
            tabsHtml += generateTabsConten(actas);
            renderTabs(tabsHtml);
            actas.forEach(acta => {
                renderTable(acta);
            });
        }
    });
}

function generateTabsHtml(actas)
{
    var tabsHtml = '';
    tabsHtml += '<ul class="nav nav-tabs">';
    tabsHtml += '<li class="pull-left header"><i class="fa fa-th"></i> Actas de Votos</li>' ;
    var firstActa = 0;
    actas.forEach(acta => {
        var classHtml = firstActa === 0 ? 'class="active"' : ''; firstActa++;
        tabsHtml += '<li ' + classHtml + '><a href="#tab_' + acta.type +  '" data-toggle="tab">' + acta.typeName + '</a></li>';
    });
    tabsHtml += '</ul>' ;
    return tabsHtml;
}

function generateRowActa(acta) {

    var actaKey = acta.type;
    var actaName = 'Actas_' + actaKey;

    var row = $('<div>', {
        'class' : "row",
    });

    var colInputs = $('<div>', {
        'class':"col-lg-12"
    });

    var label = $('<label>', {
        'for':  actaName + "_count_elector",
    }).html('Cantidad de Electores: ' + acta.count_elector,);

    var colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(label);
    colInputs.append(colLg3);

    label = $('<label>', {
        'for':  actaName + "_count_vote",
    }).html('Cantidad de Votantes: ' + acta.count_vote);

    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(label);

    colInputs.append(colLg3);

    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });


    label = $('<label>', {
        'for':  actaName + "_null_vote",
    }).html('Votos Anulados: ' + acta.null_vote);

    colLg3.append(label);
    colInputs.append(colLg3);

    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    label = $('<label>', {
        'for':  actaName + "_blank_vote",
    }).html('Votos en Blanco: ' + acta.blank_vote);

    colLg3.append(label);
    colInputs.append(colLg3);

    row.append(colInputs);

    return row;
}

function generateTabsConten(actas) {
    var tabsHtml = '';
    tabsHtml += '<div class="tab-content">';
    var firstActa = 0;
    actas.forEach(acta => {

        var rolId = acta.type;
        var actaKey = acta.type;
        var actaName = 'Actas_' + actaKey;
        var classHtml = firstActa === 0 ? ' active' : ''; firstActa++;

        actaMap.set(String(acta.type), acta);

        var tabPane = $('<div>', {
            'id' : 'tab_' + acta.type,
            'name' : 'tab' + acta.type,
            'class' : "tab-pane" + classHtml,
        });

        var row = generateRowActa(acta);

        tabPane.append(row);

        row = $('<div>', {
            'class' : "row",
        });
        var colTable =  $('<div>', {
            'class' : "col-lg-12",
        });

        var table = generateTable(acta);

        colTable.append(table);
        row.append(colTable);
        tabPane.append(row);

        tabsHtml += tabPane.get(0).outerHTML;
    });
    tabsHtml += '</div>';
    return tabsHtml;
}

function generateTable(acta)
{
    var table = $('<table>', {
        'id':'table-acta-' + acta.type,
        'class': 'display table table-bordered  table-striped table-condensed no-wrap',
        'style': 'width:100%;',
        'cellspacing':"0",
    });

    // var tableFooter = $('<tfooter>', {})
    //     .append($('<tr>', {})
    //     .append($('<td>', {}).html('Total Votos'))
    //     .append($('<td>', {}).append($('<label>', {
    //         'id': 'totalVotos_' + acta.type
    //     })).html(0)));
    //
    // console.log(tableFooter.get(0).outerHTML);
    //
    // table.append(tableFooter);

    return table;
}

function renderTable(acta) {
    var tableId = '#' + 'table-acta-' + acta.type;
    if ($(tableId).length !== 0) {
        var table = $(tableId);

        table = table.DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            // dom: '<"top"i>flBpt<"bottom"Bp><"clear">',
            // dom: '<"top"ip<"clear">>t',
            // dom: 'flrtip',
            data: acta.votos,
            "pagingType": "full_numbers",
            // 'paging': true,
            // responsive: true,
            // info: true,
            // processing: true,
            lengthMenu: [5, 10, 15],
            pageLength: 5,
            // rowId: 'postulacion_name',
            order: [[0, "asc"]],
            "language": lan,
            responsive: true,
            'columns': [
                { 'data':'postulacion_name' },
                { 'data':'vote' },
            ],
            'columnDefs': [
                {
                    orderable: true,
                    searchable: true,
                    targets:   0
                },
                {
                    targets: 0,
                    data:'postulacion_name',
                    title:'Postulación',
                },
                {
                    targets: 1,
                    data:'vote',
                    title:'Voto',
                    render: function ( data, type, full, meta )
                    {
                        return data;
                    }
                },
            ],
            // "createdRow": function( row, data, dataIndex ) {
            //     // console.log($('td input', row).eq(0));
            //     $('td input', row).eq(0).on('change', function () {
            //         alert('Voto: ' + $(this).val());
            //     });
            // }
        });

        $(tableId).on('focusout', 'input', function(event) {
            var id = $(this).data('id');
            var row = $(this).data('row');
            var acta = $(this).data('acta');
            // console.log('Voto: ' + $(this).val());
            table.cell({row: row, column: 1}).data(parseInt($(this).val()));

            actaModel = actaMap.get(acta);
            console.log('Actualizando acta', actaModel);

            var total = totalVotos(acta);
            var result = validarVotos(total, acta);
            var classValue = 'text-green';
            if(!result.error)
            {
                $('#btnSubmit').prop('disabled','');
                actaMap.set(acta, actaModel);
            }
            else
            {
                classValue = 'text-red';
                event.preventDefault();
                $('#btnSubmit').prop('disabled','disabled');
                alert(result.msg);
            }

            // actualizaTotalVotos(total, acta, classValue);
            return result.error;

        })
    }
}

function renderTabs(tabsHtml) {
    $("#container").html(tabsHtml);
}

function votosFromTableActa(acta){
    var votos = [];

    var table = $('#table-acta-' + acta).DataTable();

    table
        .rows( )
        .data()
        .each( function ( voto, index ) {
            // if(parseInt(voto.vote) !== 0)
            votos.push(voto);
        });

    return votos;
}

function getActas() {
    var actas = [];
    actaMap.forEach(function(acta, clave) {
        if(typeof acta !== 'undefined')
            acta.votos = [];
        actas.push(acta);
    });
    return actas;
}

function ajaxSaveJunta(){

    var valid = true;
    var msg = '';
    if($('#junta-recinto_eleccion_id').val() === '' || $('#junta-recinto_eleccion_id').val() === '-')
    {
        valid = false;
        msg = 'Debe especificar el recinto al que pertenece de la junta';
    }
    else if($('#junta-type').val() == '')
    {

        valid = false;
        msg = 'Debe especificar el tipo de la junta';
    }
    else if($('#junta-name').val() == '')
    {

        valid = false;
        msg = 'Debe especificar el nombre de la junta';
    }

    if(!valid)
    {
        $.alert(
            {
                title:'Advertencia!',
                content: msg,
                buttons: {
                    confirm: {
                        text:'Aceptar',
                        action:function () {
                            return;
                        }
                    }
                }
            }
        );
        return;
    }


    var junta = {
        id: modelId,
        type: $('#junta-type').val(),
        recinto: recintoId,
        name: $('#junta-name').val()
    } ;

    $.ajax({
        url: homeUrl + 'junta/save-junta',
        type: "POST",
        data:junta,
        success:function (response) {

            if(response.success)
            {
                modelId = response.data.id;
                ajaxSaveActas();
            }

            if(!response.success)
                alert(response.msg);
        }
    });
}

function ajaxSaveActas(){
    var actas = getActas();

    $.ajax({
        url: homeUrl + 'junta/save-actas',
        type: "POST",
        data:{
            juntaId: modelId,
            actas: actas,
        },
        success:function (response) {

            if(response.success)
            {
                var  actas = response.data
                pendingSaveVotes = [];
                for(var i = 0 ; i < actas.length; i++)
                {
                    var acta = actas[i];
                    actaMap.set(acta.type, acta);
                    pendingSaveVotes.push(acta.type);
                }

                ajaxSaveVotes();
                return;
            }

            if(!response.success)
                alert(response.msg);
        }
    });
}

var pendingSaveVotes = [];

function ajaxSaveVotes() {
    if(pendingSaveVotes.length == 0) return;

    var actaType = pendingSaveVotes.pop();

    ajaxSaveActaVotes(votosFromTableActa(actaType), actaMap.get(actaType));
}

function ajaxSaveActaVotes(votos, acta) {

    if(acta !== null && votos.length > 0)
    {
        $.ajax({
            url: homeUrl + 'junta/save-votos',
            type: "POST",
            data:{
                acta: acta,
                votos: votos,
            },
            success:function (response) {

                if(response.success)
                {
                    if(pendingSaveVotes.length == 0) return;
                    ajaxSaveVotes();
                }

                if(!response.success) {
                    alert(response.msg);
                    pendingSaveVotes.push(acta.type);
                }

            }
        });
    }
}

function handleFormSubmit(){
    // form submit
    $('#btnSubmit').on('click', function(event){
        event.preventDefault();

        ajaxSaveJunta();

        // $('#w0').submit();
    });
}

$(document).ready(function () {

    console.log('recintoId', recintoId);
    console.log('modelId', modelId);

    reloadVotos();

});