var table;

$(document).ready(function () {

    ajaxcsrf();

    table = $("#prueba").DataTable({
        initComplete: function () {
            var api = this.api();
            $('#prueba_filter input')
                .off('.DT')
                .on('keyup.DT', function (e) {
                    api.search(this.value).draw();
                });
        },
        oLanguage: {
            sProcessing: "cargando..."
        },
        processing: true,
        serverSide: true,
        ajax: {
            "url": base_url+"Prueba/list_json",
            "type": "POST",
        },
        columns: [
            {
                "data": "id_prueba",
                "orderable": false,
                "searchable": false
            },
            { "data": 'nombre_prueba' },
            { "data": 'nombre_curso' },
            { "data": 'nombre_profesor' },
            { "data": 'cantidad_banco_preguntas' },
            { "data": 'tiempo' },
            {
                "searchable": false,
                "orderable": false
            }
        ],
        columnDefs: [
            {
                "targets": 6,
                "data": {
                    "id_prueba": "id_prueba",
                    "ada": "ada"
                },
                "render": function (data, type, row, meta) {
                    var btn;
                    if (data.ada > 0) {
                        btn = `
								<a class="btn btn-xs btn-success" href="${base_url}resultado_examen/imprimir/${data.id_prueba}" target="_blank">
									<i class="fa fa-print"></i> Imprimir Resultados
								</a>`;
                    } else {
                        btn = `<a class="btn btn-xs btn-primary" href="${base_url}prueba/token/${data.id_prueba}">
								<i class="fa fa-pencil"></i> Tomar Examen
							</a>`;
                    }
                    return `<div class="text-center">
									${btn}
								</div>`;
                }
            },
        ],
        order: [
            [1, 'asc']
        ],
        rowId: function (a) {
            return a;
        },
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });
});