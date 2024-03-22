$(document).ready(function() {
    var t = $('.sisawaktu');
    if (t.length) {
        sisawaktu(t.data('time'));
    }

    buka(1);
    simpan_sementara();

    widget = $(".step");
    btnnext = $(".next");
    btnback = $(".back");
    btnsubmit = $(".submit");

    $(".step, .back, .selesai").hide();
    $("#widget_1").show();
});

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i) {
        indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
}

function buka(id_widget) {
    $(".next").attr('rel', (id_widget + 1));
    $(".back").attr('rel', (id_widget - 1));
    $(".ragu_ragu").attr('rel', (id_widget));
    cek_status_ragu(id_widget);
    cek_terakhir(id_widget);

    $("#preguntas").html(id_widget);

    $(".step").hide();
    $("#widget_" + id_widget).show();

    simpan();
}

function next() {
    var berikutnya = $(".next").attr('rel');
    berikutnya = parseInt(berikutnya);
    berikutnya = berikutnya > total_widget ? total_widget : berikutnya;

    $("#preguntas").html(berikutnya);

    $(".next").attr('rel', (berikutnya + 1));
    $(".back").attr('rel', (berikutnya - 1));
    $(".ragu_ragu").attr('rel', (berikutnya));
    cek_status_ragu(berikutnya);
    cek_terakhir(berikutnya);

    var sudah_akhir = berikutnya == total_widget ? 1 : 0;

    $(".step").hide();
    $("#widget_" + berikutnya).show();

    if (sudah_akhir == 1) {
        $(".back").show();
        $(".next").hide();
    } else if (sudah_akhir == 0) {
        $(".next").show();
        $(".back").show();
    }

    simpan();
}

function back() {
    var back = $(".back").attr('rel');
    back = parseInt(back);
    back = back < 1 ? 1 : back;

    $("#preguntas").html(back);

    $(".back").attr('rel', (back - 1));
    $(".next").attr('rel', (back + 1));
    $(".ragu_ragu").attr('rel', (back));
    cek_status_ragu(back);
    cek_terakhir(back);

    $(".step").hide();
    $("#widget_" + back).show();

    var sudah_awal = back == 1 ? 1 : 0;

    $(".step").hide();
    $("#widget_" + back).show();

    if (sudah_awal == 1) {
        $(".back").hide();
        $(".next").show();
    } else if (sudah_awal == 0) {
        $(".next").show();
        $(".back").show();
    }

    simpan();
}

function tidak_jawab() {
    var id_step = $(".ragu_ragu").attr('rel');
    var status_ragu = $("#rg_" + id_step).val();

    if (status_ragu == "N") {
        $("#rg_" + id_step).val('Y');
        $("#btn_banco_preguntas_" + id_step).removeClass('btn-success');
        $("#btn_banco_preguntas_" + id_step).addClass('btn-primary');

    } else {
        $("#rg_" + id_step).val('N');
        $("#btn_banco_preguntas_" + id_step).removeClass('btn-primary');
        $("#btn_banco_preguntas_" + id_step).addClass('btn-success');
    }

    cek_status_ragu(id_step);

    simpan();
}

function cek_status_ragu(id_banco_preguntas) {
    var status_ragu = $("#rg_" + id_banco_preguntas).val();

    if (status_ragu == "N") {
        $(".ragu_ragu").html('Doubt');
    } else {
        $(".ragu_ragu").html('No doubt');
    }
}

function cek_terakhir(id_banco_preguntas) {
    var numero_preguntas = $("#numero_preguntas").val();
    numero_preguntas = (parseInt(numero_preguntas) - 1);

    if (numero_preguntas === id_banco_preguntas) {
        $('.next').hide();
        $(".selesai, .back").show();
    } else {
        $('.next').show();
        $(".selesai, .back").hide();
    }
}

function simpan_sementara() {
    var f_asal = $("#prueba");
    var form = getFormData(f_asal);
    //form = JSON.stringify(form);
    var numero_preguntas = form.numero_preguntas;
    numero_preguntas = parseInt(numero_preguntas);

    var resultado_respuesta = "";

    for (var i = 1; i < numero_preguntas; i++) {
        var idx = 'opsi_' + i;
        var idx2 = 'rg_' + i;
        var jawab = form[idx];
        var ragu = form[idx2];

        if (jawab != undefined) {
            if (ragu == "Y") {
                if (jawab == "-") {
                    resultado_respuesta += '<a id="btn_banco_preguntas_' + (i) + '" class="btn btn-default btn_banco_preguntas btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                } else {
                    resultado_respuesta += '<a id="btn_banco_preguntas_' + (i) + '" class="btn btn-primary btn_banco_preguntas btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                }
            } else {
                if (jawab == "-") {
                    resultado_respuesta += '<a id="btn_banco_preguntas_' + (i) + '" class="btn btn-default btn_banco_preguntas btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                } else {
                    resultado_respuesta += '<a id="btn_banco_preguntas_' + (i) + '" class="btn btn-success btn_banco_preguntas btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab + "</a>";
                }
            }
        } else {
            resultado_respuesta += '<a id="btn_banco_preguntas_' + (i) + '" class="btn btn-default btn_banco_preguntas btn-sm" onclick="return buka(' + (i) + ');">' + (i) + ". -</a>";
        }
    }
    $("#tampil_respuesta").html('<div id="yes"></div>' + resultado_respuesta);
}

function simpan() {
    simpan_sementara();
    var form = $("#prueba");

    $.ajax({
        type: "POST",
        url: base_url + "prueba/simpan_satu",
        data: form.serialize(),
        dataType: 'json',
        success: function(data) {
            // $('.ajax-loading').show();
            console.log(data);
        }
    });
}

function finalizado() {
    simpan();
    ajaxcsrf();
    $.ajax({
        type: "POST",
        url: base_url + "prueba/simpan_akhir",
        data: { id: id_tes },
        beforeSend: function() {
            simpan();
            // $('.ajax-loading').show();    
        },
        success: function(r) {
            console.log(r);
            if (r.status) {
                window.location.href = base_url + 'prueba/list';
            }
        }
    });
}

function tiempoFinalizado() {
    finalizado();
    alert('Exam time is up!');
}

function simpan_akhir() {
    simpan();
    if (confirm('Are you sure you want to end the test?')) {
        finalizado();
    }
}