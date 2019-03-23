var actas = [];

function totalVotos(acta) {
    var votes = $('*').filter(function () {
        return this.id.match('^Votes_[1-9][0-9]*_vote$');
    });

    var total = 0;
    for(var i = 0 ; i < votes.length; i++)
    {
        if($(votes[i]).attr('data-acta') === acta)
            total += parseInt(votes[i].value);
    }

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

    return result;
}

function handleActas(){
    var actaValues = ['count_elector', 'count_vote', 'blank_vote', 'null_vote'];

    for(var i = 0 ; i < actaValues.length; i++)
    {
        var actaValue = actaValues[i];

        var actas = $('*').filter(function () {
            var reg = '^Actas_[1-9][0-9]*_' + actaValue + '$';
            return this.id.match(reg);
        });

        for(var j = 0 ; j < actas.length; j++)
        {
            $(actas[j]).on('keyup', function (event) {
                var keyup= event.which;
                var acta = $(this).attr('data-acta');

                var total = totalVotos(acta);

                var result = validarVotos(total, acta);

                var classValue = 'text-green';

                if(!result.error)
                {
                    $('#btnSubmit').prop('disabled','');
                }
                else
                {
                    classValue = 'text-red';
                    event.preventDefault();
                    $('#btnSubmit').prop('disabled','disabled');
                    alert(result.msg);
                }

                actualizaTotalVotos(total, acta, classValue);
                return result.error;
            });
        }
    }
}

function handleVotes(){
    var votes = $('*').filter(function () {
        return this.id.match('^Votes_[1-9][0-9]*_vote$');
    });

    for(var i = 0 ; i < votes.length; i++)
    {
        $(votes[i]).on('keyup', function (event) {
            var keyup= event.which;

            // console.log('keyup', keyup);
            // console.log('input value', this.value);

            var acta = $(this).attr('data-acta');

            console.log('acta', acta);

            var total = totalVotos(acta);

            console.log('total', total);

            var result = validarVotos(total, acta);

            var classValue = 'text-green';

            if(!result.error)
            {
                $('#btnSubmit').prop('disabled','');
            }
            else
            {
                classValue = 'text-red';
                event.preventDefault();
                $('#btnSubmit').prop('disabled','disabled');
                alert(result.msg);
            }

            actualizaTotalVotos(total, acta, classValue);
            return result.error;
        });
    }
}

function reloadVotos(){
    var loadingHtml = '<div class="overlay">' + '<i class="fa fa-circle-o-notch fa-spin"></i>' + '</div>';

    $("#container").html(loadingHtml);
    $.ajax({
        url: homeUrl + "/junta/generar-actas",
        data:{
            "canton":$("#canton_select2").val(),
            "recinto":recintoId,
            "junta": modelId
        },
        success:function (response) {
            actas = response.data;
            var tabsHtml = generateTabsHtml(actas);
            tabsHtml += generateTabsConten(actas);
            renderTabs(tabsHtml);
            actas.forEach(acta => {
                renderTable(acta);
            });

            // handleActas();
            // handleVotes();
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

    var actaKey = acta.id == null ? acta.type : acta.id;
    var actaName = 'Actas_' + actaKey;

    var row = $('<div>', {
        'class' : "row",
    });

    var colInputs = $('<div>', {
        'class':"col-lg-12"
    });

    var inputType = $('<input>', {
        'id' : actaName + "_type",
        'name' : 'Actas[' + actaKey +'][type]',
        'data-acta' : actaKey,
        'value': acta.type,
        'require' : true,
        'type': 'number',
        'style':"display: none;",
    });

    colInputs.append(inputType);

    var formGroup = $('<div>', {
        class : "form-group"
    });

    var label = $('<label>', {
        'for':  actaName + "_type",
    }).html('Cantidad de Electores');

    var inputCountElector = $('<input>', {
        'id' : actaName + "_count_elector",
        'name' : 'Actas[' + actaKey +'][count_elector]',
        'data-acta' : actaKey,
        'value': acta.count_elector,
        'require' : true,
        'type': 'number',
    });

    formGroup.append(label);
    formGroup.append(inputCountElector);
    var colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(formGroup);
    colInputs.append(colLg3);

    formGroup = $('<div>', {
        class : "form-group"
    });

    label = $('<label>', {
        'for':  actaName + "_type",
    }).html('Cantidad de Votantes');

    var inputCountVote = $('<input>', {
        'id' : actaName + "_count_vote",
        'name' : 'Actas[' + actaKey +'][count_vote]',
        'data-acta' : actaKey,
        'value': acta.count_vote,
        'require' : true,
        'type': 'number',
    });

    formGroup.append(label);
    formGroup.append(inputCountVote);
    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(formGroup);
    colInputs.append(colLg3);

    formGroup = $('<div>', {
        class : "form-group"
    });

    label = $('<label>', {
        'for':  actaName + "_type",
    }).html('Votos Anulados');

    var inputVotosNulos = $('<input>', {
        'id' : actaName + "_null_vote",
        'name' : 'Actas[' + actaKey +'][null_vote]',
        'data-acta' : actaKey,
        'value': acta.null_vote,
        'require' : true,
        'type': 'number',
    });

    formGroup.append(label);
    formGroup.append(inputVotosNulos);
    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(formGroup);
    colInputs.append(colLg3);

    formGroup = $('<div>', {
        class : "form-group"
    });

    label = $('<label>', {
        'for':  actaName + "_type",
    }).html('Votos en Blanco');

    var inputVotosBlancos = $('<input>', {
        'id' : actaName + "_blank_vote",
        'name' : 'Actas[' + actaKey +'][blank_vote]',
        'data-acta' : actaKey,
        'value': acta.blank_vote,
        'require' : true,
        'type': 'number',
    });

    formGroup.append(label);
    formGroup.append(inputVotosBlancos);
    colLg3 = $('<div>', {
        'class':"col-lg-3"
    });

    colLg3.append(formGroup);
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
        var actaKey = acta.id == null ? acta.type : acta.id;
        var actaName = 'Actas_' + actaKey;
        var classHtml = firstActa === 0 ? ' active' : ''; firstActa++;

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
                        if(type == 'display')
                        {
                            var key = full.id == null ? full.postulacion_id : full.id;
                            var voteKey = 'Votes_' + key;

                            var inputVotosBlancos = $('<input>', {
                                'id' : voteKey,
                                'value': data,
                                'data-id': key,
                                'data-row': meta.row,
                                'require' : true,
                                'type': 'number',
                            });

                            return inputVotosBlancos.get(0).outerHTML;
                        }
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

        $(tableId).on('change', 'input', function() {
            var id = $(this).data('id');
            var row = $(this).data('row');
            // console.log('Voto: ' + $(this).val());
            table.cell({row: row, column: 1}).data($(this).val());

        })
    }
}

function renderTabs(tabsHtml) {
    $("#container").html(tabsHtml);
}

function dataFromActas() {
    var actaValues = ['count_elector', 'count_vote', 'blank_vote', 'null_vote'];

    for(var i = 0 ; i < actaValues.length; i++)
    {
        var actaValue = actaValues[i];

        var actas = $('*').filter(function () {
            var reg = '^Actas_[1-9][0-9]*_' + actaValue + '$';
            return this.id.match(reg);
        });

        for(var j = 0 ; j < actas.length; j++)
        {
            $(actas[j]).on('keyup', function (event) {
                var keyup= event.which;
                var acta = $(this).attr('data-acta');

                var total = totalVotos(acta);

                var result = validarVotos(total, acta);

                var classValue = 'text-green';

                if(!result.error)
                {
                    $('#btnSubmit').prop('disabled','');
                }
                else
                {
                    classValue = 'text-red';
                    event.preventDefault();
                    $('#btnSubmit').prop('disabled','disabled');
                    alert(result.msg);
                }

                actualizaTotalVotos(total, acta, classValue);
                return result.error;
            });
        }
    }
}

function handleFormSubmit(){
    // form submit
    $('#aceptBtn').on('click', function(){
        var formData = $('#w0').serialize();

        console.log(formData);

        $('#w0').submit();
    });
}

$(document).ready(function () {

    console.log('recintoId', recintoId);
    console.log('modelId', modelId);

    handleFormSubmit();
    reloadVotos();

});