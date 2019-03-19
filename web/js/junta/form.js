function validationVote(inputVote, value){
    // console.log('validationVote');
    // console.log('validationVote', inputVote);
    // console.log('validationVote', value);

    var votes = $('*').filter(function () {
        return this.id.match('^Votes_[1-9][0-9]+_vote$');
    });

    var total = 0;
    for(var i = 0 ; i < votes.length; i++)
    {
        total += parseInt(votes[i].value);
    }

    $('#totalVotos').html(total);
};

$(document).ready(function () {
    $('#junta-recinto_eleccion_id').on('change', function () {
        console.log('junta-recinto_eleccion_id', this.value);
    });
});