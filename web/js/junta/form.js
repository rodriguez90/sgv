function totalVotos() {
    var votes = $('*').filter(function () {
        return this.id.match('^Votes_[1-9][0-9]*_vote$');
    });

    var total = 0;
    for(var i = 0 ; i < votes.length; i++)
    {
        total += parseInt(votes[i].value);
    }

    total += parseInt($("#junta-null_vote").prop('value')) + parseInt($("#junta-blank_vote").prop('value'));

    return total;
}

function actualizaTotalVotos(total) {
    $('#totalVotos').html(total);
}

function validarVotos(total) {
    var cantidadElectores = parseInt($("#junta-count_elector").prop('value'));
    var cantidadVotantes = parseInt($("#junta-count_vote").prop('value'));

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

            var total = totalVotos();

            var result = validarVotos(total);

            if(!result.error)
            {
                actualizaTotalVotos(total);
                $('#btnSubmit').prop('disabled','');
                return true;
            }
            else
            {
                event.preventDefault();
                $('#btnSubmit').prop('disabled','disabled');
                alert(result.msg);
                return false;
            }
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
            handleVotes();
        }
    });
}

$(document).ready(function () {

    console.log('recintoId', recintoId);
    console.log('modelId', modelId);

    reloadVotos();

    $("#junta-count_elector").on('keyup', function (event) {
        var total = totalVotos();

        var result = validarVotos(total);

        if(!result.error)
        {
            actualizaTotalVotos(total);
            $('#btnSubmit').prop('disabled','');
            return true;
        }
        else
        {
            event.preventDefault();
            $('#btnSubmit').prop('disabled','disabled');
            alert(result.msg);
            return false;
        }
    });

    $("#junta-count_vote").on('keyup', function (event) {
        var total = totalVotos();

        var result = validarVotos(total);

        if(!result.error)
        {
            actualizaTotalVotos(total);
            $('#btnSubmit').prop('disabled','');
            return true;
        }
        else
        {
            event.preventDefault();
            $('#btnSubmit').prop('disabled','disabled');
            alert(result.msg);
            return false;
        }
    });

    $("#junta-null_vote").on('keyup', function (event) {
        var total = totalVotos();

        var result = validarVotos(total);

        if(!result.error)
        {
            actualizaTotalVotos(total);
            $('#btnSubmit').prop('disabled','');
            return true;
        }
        else
        {
            event.preventDefault();
            $('#btnSubmit').prop('disabled','disabled');
            alert(result.msg);
            return false;
        }
    });

    $("#junta-blank_vote").on('keyup', function (event) {
        var total = totalVotos();

        var result = validarVotos(total);

        if(!result.error)
        {
            actualizaTotalVotos(total);
            $('#btnSubmit').prop('disabled','');
            return true;
        }
        else
        {
            event.preventDefault();
            $('#btnSubmit').prop('disabled','disabled');
            alert(result.msg);
            return false;
        }
    });


});