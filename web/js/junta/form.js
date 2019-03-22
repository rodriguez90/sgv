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
    $.ajax({
        url: homeUrl + "/junta/ajaxcall",
        data:{
            "recintoId":recintoId,
            "modelId": modelId
        },
        success:function (data) {
            $("#container").html(data);
            handleActas();
            handleVotes();
        }
    });
}

$(document).ready(function () {

    console.log('recintoId', recintoId);
    console.log('modelId', modelId);

    reloadVotos();

});