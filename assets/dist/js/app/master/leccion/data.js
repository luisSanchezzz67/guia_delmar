var save_label;
var table;

$(document).ready(function () {
  ajaxcsrf();

  table = $("#leccion").DataTable({
    initComplete: function () {
      var api = this.api();
      $("#kelas_filter input")
        .off(".DT")
        .on("keyup.DT", function (e) {
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
        exportOptions: { columns: [1, 2] },
      },
      {
        extend: "print",
        exportOptions: { columns: [1, 2] },
      },
      {
        extend: "excel",
        exportOptions: { columns: [1, 2] },
      },
      {
        extend: "pdf",
        exportOptions: { columns: [1, 2] },
      },
    ],
    oLanguage: {
      sProcessing: "loading...",
    },
    processing: true,
    serverSide: true,
    ajax: {
      url: base_url + "leccion/data",
      type: "POST",
      //data: csrf
    },
    columns: [
      {
        data: "id",
        orderable: false,
        searchable: false,
      },
      { data: "titulo" },
      {
        data: "video",
        render: function (data, type, row) {
          return data
            ? " <ul class='nav nav-pills' role='tablist'> <li role='presentation' class='active'><a class='video-active'><i class='fa fa-video-camera'></i> Tiene video </a></li></ul>"
            : "<ul class='nav nav-pills' role='tablist'> <li role='presentation' class='active'><a class='video-not'><i class='fa fa-video-camera'></i> No tiene video </a></li></ul>";
        },
      },
      { data: "status" },
        {
            data: "fecha_inicial",
            render: function (data, type, row) {
                return moment(data).locale('es').format('D [de] MMMM [del] YYYY [a las] HH:mm');
            }
        },
        {
            data: "fecha_disponible",
            render: function (data, type, row) {
                return moment(data).locale('es').format('D [de] MMMM [del] YYYY [a las] HH:mm');
            }
        }
      // { data: "fecha_inicial" },
      // { data: "fecha_disponible" },
    ],
    columnDefs: [
      {
        searchable: false,
        targets: 6,
        data: {
          id: "id",
          ada: "ada",
        },
        render: function (data, type, row, meta) {
          if (esAdministrador) {
          return `
            
            <div class="btn">
							<a href="${base_url}leccion/view/${data.id}" class="btn m-0 mx-0 mt-0 btn-primary">
								<i class="fa fa-eye"></i> 
							</a>
						</div>
            <div class="btn">
							<a href="${base_url}leccion/edit/${data.id}" class="btn m-0 mx-0 mt-0 btn-primary">
								<i class="fa fa-pencil"></i>
							</a>
						</div>
            <div class="btn">
							<button onclick="leccion_delete(${data.id}); return false;" class="btn m-0 mx-0 mt-0 btn-primary">
								<i class="fa fa-trash"></i>
							</button>
						</div>`;
          } else {
            return `<div class="btn">
            <a href="${base_url}leccion/view/${data.id}" class="btn m-0 mx-0 mt-0 btn-primary">
              <i class="fa fa-eye"></i> 
            </a>
          </div>`;
          }

        },
        
      },
      
    ],
    
    order: [[1, "asc"]],
    rowId: function (a) {
      return a;
    },
    rowCallback: function (row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(0)", row).html(index);
    },
  });

  table.buttons().container().appendTo("#kelas_wrapper .col-md-6:eq(0)");

  $("#myModal").on("shown.modal.bs", function () {
    $(':input[name="lote"]').select();
  });

  $("#select_all").on("click", function () {
    if (this.checked) {
      $(".check").each(function () {
        this.checked = true;
      });
    } else {
      $(".check").each(function () {
        this.checked = false;
      });
    }
  });

  $("#leccion tbody").on("click", "tr .check", function () {
    var check = $("#leccion tbody tr .check").length;
    var checked = $("#leccion tbody tr .check:checked").length;
    if (check === checked) {
      $("#select_all").prop("checked", true);
    } else {
      $("#select_all").prop("checked", false);
    }
  });

  $("#bulk").on("submit", function (e) {
    if ($(this).attr("action") == base_url + "leccion/delete") {
      e.preventDefault();
      e.stopImmediatePropagation();

      $.ajax({
        url: $(this).attr("action"),
        data: $(this).serialize(),
        type: "POST",
        success: function (respon) {
          if (respon.status) {
            Swal({
              title: "Exito",
              text: respon.total + " Eliminación exitosa",
              type: "success",
            });
          } else {
            Swal({
              title: "Failed",
              text: "No data selected",
              type: "error",
            });
          }
          reload_ajax();
        },
        error: function () {
          Swal({
            title: "Failed",
            text: "There is data in use",
            type: "error",
          });
        },
      });
    }
  });
});

function load_grupo() {
  var grupo = $('select[name="nombre_grupo"]');
  grupo.children("option:not(:first)").remove();

  ajaxcsrf(); // get csrf token
  $.ajax({
    url: base_url + "grupo/load_grupo",
    type: "GET",
    success: function (data) {
      //console.log(data);
      if (data.length) {
        var dataGrupo;
        $.each(data, function (key, val) {
          dataGrupo = `<option value="${val.id_grupo}">${val.nombre_grupo}</option>`;
          grupo.append(dataGrupo);
        });
      }
    },
  });
}

function leccion_delete(id_curso) {
  
  $("#bulk").attr("action", base_url + "leccion/delete/" + id_curso);
    Swal({
      title: "Seguro?",
      text: "Estos datos serán eliminados!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Eliminar!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: base_url + "leccion/delete/" + id_curso,
          type: "POST",
          success: function(response) {
            Swal.fire({
              title: 'Eliminado!',
              text: 'La lección ha sido eliminada correctamente.',
              type: 'success'
            }).then(() => {
              location.reload(); // Recarga la página cuando el usuario cierra el SweetAlert
            });
          },
          error: function(xhr, status, error) {
            Swal('Error', 'No se pudo eliminar la lección: ' + error, 'error');
          }
        });
      }
    });
  
}



