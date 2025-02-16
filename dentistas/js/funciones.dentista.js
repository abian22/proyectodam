function abrirModalDentista(boton, id) {
  $("#form-crear-editar-dentista-id").val(id);

  if (id > 0) {
    let formData = new FormData();
    formData.append("tarea", "CARGAR_DENTISTA");
    formData.append("id", $("#form-crear-editar-dentista-id").val());

    $.ajax({
      url: RUTA_URL_API + "/api.dentista.php",
      method: "POST",
      data: formData, // Enviar el objeto FormData
      contentType: false, // No establecer el encabezado Content-Type manualmente
      processData: false, // No procesar los datos (necesario para FormData)

      success: function (respuesta) {
        if (respuesta.exito === 0) {
          alert(respuesta.mensaje);
        }

        if (respuesta.exito === 1) {
          $("#form-crear-editar-dentista-nombre").val(respuesta.datos.nombre);
          $("#form-crear-editar-dentista-apellidos").val(respuesta.datos.apellidos);
          $("#form-crear-editar-dentista-email").val(respuesta.datos.email);
          $("#form-crear-editar-dentista-bloqueado").prop("checked", respuesta.datos.bloqueado);

        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error al enviar el formulario");
      },
    });
  } else {
    $(".form-control").val("");
  }
  $("#modal-crear-editar-dentista").modal("show");
}

function guardarDentista(boton) {
  const form = $("#form-crear-editar-dentista").get(0);

  $(".form-control").removeClass("is-invalid");
  $("#form-crear-editar-dentista-feedback").removeClass("text-bg-danger text-bg-success");
  $("#form-crear-editar-dentista-feedback").html("");

  let formData = new FormData(form);
  formData.append("tarea", "GUARDAR_DENTISTA");
  formData.set("bloqueado", $("#form-crear-editar-dentista-bloqueado").prop("checked"));

  $.ajax({
    url: RUTA_URL_API + "/api.dentista.php",
    method: "POST",
    data: formData, // Enviar el objeto FormData
    contentType: false, // No establecer el encabezado Content-Type manualmente
    processData: false, // No procesar los datos (necesario para FormData)

    success: function (respuesta) {
      if (respuesta.exito === 0) {
        $("#form-crear-editar-dentista-feedback").addClass("text-bg-danger");
        $("#form-crear-editar-dentista-feedback").html(respuesta.mensaje);
      }

      if (respuesta.exito === 1) {
        $("#modal-crear-editar-dentista").modal("hide");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      alert("Ocurrió un error al enviar el formulario");
    },
  });
}
