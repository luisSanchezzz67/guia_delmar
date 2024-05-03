$(document).ready(function () {
    $(".datetimepicker").datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
      });
    $('#formleccion').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $('#submit');

        btn.attr('disabled', 'disabled').text('Cargando');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            success: function (response) {
                btn.removeAttr('disabled').text('Update');
                if (response.status) {
                    Swal('Success', 'Data successfully updated', 'success')
                        .then((result) => {
                            if (result.value) {
                                window.location.href = base_url+'leccion';
                            }
                        });
                } else {
                    $.each(response.errors, function (key, val) {
                        $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                        $('[name="' + key + '"]').nextAll('.help-block').eq(0).text(val);
                        if (val === '') {
                            $('[name="' + key + '"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                            $('[name="' + key + '"]').nextAll('.help-block').eq(0).text('');
                        }
                    });
                }
            }
        })
    });

    $('#formleccion input, #formleccion select').on('change', function () {
        $(this).closest('.form-group').removeClass('has-error has-success');
        $(this).nextAll('.help-block').eq(0).text('');
    });
});
// $(document).ready(function () {
//     $('form#leccion input, form#leccion select').on('change', function () {
//         $(this).closest('.form-group').removeClass('has-error');
//         $(this).next().next().text('');
//     });

//     $('formleccion').on('submit', function (e) {
        
//         console.log('Probando formulariio');
//         e.preventDefault();
//         e.stopImmediatePropagation();

//         var btn = $('#submit');
//         btn.attr('disabled', 'disabled').text('Cargando');

//         $.ajax({
//             url: $(this).attr('action'),
//             data: $(this).serialize(),
//             method: 'POST',
//             success: function (data) {
//                 btn.removeAttr('disabled').text('Guardar');
//                 //console.log(data);
//                 if (data.status) {
//                     Swal({
//                         "title": "Proceso Exitoso",
//                         "text": "Datos Guardados Exitosamente",
//                         "type": "success"
//                     }).then((result) => {
//                         if (result.value) {
//                             window.location.href = base_url+'leccion';
//                         }
//                     });
//                 } else {
//                     var j;
//                     for (let i = 0; i <= data.errors.length; i++) {
//                         $.each(data.errors[i], function (key, val) {
//                             j = $('[name="' + key + '"]');
//                             j.closest('.form-group').addClass('has-error');
//                             j.next().next().text(val);
//                             if (val == '') {
//                                 j.closest('.form-group').addClass('has-error');
//                                 j.next().next().text('');
//                             }
//                         });
//                     }
//                 }
//             }
//         });
//     });
// });