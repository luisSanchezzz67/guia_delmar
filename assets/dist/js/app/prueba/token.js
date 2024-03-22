$(document).ready(function() {
    ajaxcsrf();

    $('#btncek').on('click', function() {
        var token = $('#token').val();
        var idPrueba = $(this).data('id');
        if (token === '') {
            Swal('Failed', 'Token must be filled', 'error');
        } else {
            var key = $('#id_prueba').data('key');
            $.ajax({
                url: base_url + 'Prueba/cektoken/',
                type: 'POST',
                data: {
                    id_prueba: idPrueba,
                    token: token
                },
                cache: false,
                success: function(result) {
                    Swal({
                        "type": result.status ? "success" : "error",
                        "title": result.status ? "Successful" : "Failed",
                        "text": result.status ? "True Token" : "Incorrect Token"
                    }).then((data) => {
                        if (result.status) {
                            location.href = base_url + 'Prueba/?key=' + key;
                        }
                    });
                }
            });
        }
    });

    var time = $('.countdown');
    if (time.length) {
        countdown(time.data('time'));
    }
});