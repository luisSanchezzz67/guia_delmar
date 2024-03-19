function loadGrupo(id) {
    $('#grupo option').remove();
    $.getJSON(base_url+'grupocurso/getGrupoId/' + id, function (data) {
        console.log(data);
        let opsi;
        $.each(data, function (key, val) {
            opsi = `
                    <option value="${val.id_grupo}">${val.nombre_grupo}</option>
                `;
            $('#grupo').append(opsi);
        });
    });
}

$(document).ready(function () {
    $('[name="curso_id"]').on('change', function () {
        loadGrupo($(this).val());
    });

    $('form#grupocurso select').on('change', function () {
        $(this).closest('.form-group').removeClass('has-error');
        $(this).nextAll('.help-block').eq(0).text('');
    });

    $('form#grupocurso').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var btn = $('#submit');
        btn.attr('disabled', 'disabled').text('Cargando');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            method: 'POST',
            success: function (data) {
                btn.removeAttr('disabled').text('Guardar');
                console.log(data);
                if (data.status) {
                    Swal({
                        "title": "Proceso Exitoso",
                        "text": "Data Datos Guardados Exitosamente",
                        "type": "success"
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = base_url+'grupocurso';
                        }
                    });
                } else {
                    if (data.errors) {
                        let j;
                        $.each(data.errors, function (key, val) {
                            j = $('[name="' + key + '"]');
                            j.closest('.form-group').addClass('has-error');
                            j.nextAll('.help-block').eq(0).text(val);
                            if (val == '') {
                                j.parent().addClass('has-error');
                                j.nextAll('.help-block').eq(0).text('');
                            }
                        });
                    }
                }
            }
        });
    });
});