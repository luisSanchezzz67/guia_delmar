var table;

$(document).ready(function() {
  ajaxcsrf();

  table = $("#resultado").DataTable({
    initComplete: function() {
      var api = this.api();
      $("#resultado_filter input")
        .off(".DT")
        .on("keyup.DT", function(e) {
          api.search(this.value).draw();
        });
    },
    dom:
      "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: "copy",
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      },
      {
        extend: "print",
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      },
      {
        extend: "excel",
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      },
      {
        extend: "pdf",
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
      }
    ],
    oLanguage: {
      sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {
      url: base_url + "resultado_examen/data",
      type: "POST"
    },
    columns: [
      {
        data: "id_prueba",
        orderable: false,
        searchable: false
      },
      { data: "nombre_prueba" },
      { data: "nombre_curso" },
      { data: "nombre_profesor" },
      { data: "cantidad_banco_preguntas" },
      { data: "tiempo" },
      { data: "fecha_inicio" },
      {
        orderable: false,
        searchable: false
      }
    ],
    columnDefs: [
      {
        targets: 7,
        data: "id_prueba",
        render: function(data, type, row, meta) {
          return `
                    <div class="text-center">
                        <a class="btn btn-xs bg-green" href="${base_url}resultado_examen/detail/${data}" >
                            <i class="fa fa-search"></i> Ver Resultados
                        </a>
                    </div>
                    `;
        }
      }
    ],
    order: [[1, "asc"]],
    rowId: function(a) {
      return a;
    },
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(0)", row).html(index);
    }
  });
});

table
  .buttons()
  .container()
  .appendTo("#resultado_wrapper .col-md-6:eq(0)");
