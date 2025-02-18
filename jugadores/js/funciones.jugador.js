function abrirModalJugador(boton, id) {
  $("#form-crear-editar-jugador-id").val(id);

  $(".form-control").removeClass("is-invalid");
  $("#form-crear-editar-jugador-feedback").removeClass(
    "text-bg-danger text-bg-success"
  );
  $("#form-crear-editar-jugador-feedback").html("");

  if (id > 0) {
    let formData = new FormData();
    formData.append("tarea", "CARGAR_JUGADOR");
    formData.append("id", $("#form-crear-editar-jugador-id").val());
    $(".form-control").val("");
    
    $.ajax({
      url: RUTA_URL_API + "/api.jugador.php",
      method: "POST",
      data: formData, // Enviar el objeto FormData
      contentType: false, // No establecer el encabezado Content-Type manualmente
      processData: false, // No procesar los datos (necesario para FormData)

      success: function (respuesta) {
        if (respuesta.exito === 0) {
          alert(respuesta.mensaje);
        }

        if (respuesta.exito === 1) {
          $("#form-crear-editar-jugador-nombre").val(respuesta.datos.nombre);
          $("#form-crear-editar-jugador-apellidos").val(
            respuesta.datos.apellidos
          );
          $("#form-crear-editar-jugador-email").val(respuesta.datos.email);
          $("#form-crear-editar-jugador-juego").val(respuesta.datos.juego);
          $("#form-crear-editar-jugador-ranking").val(respuesta.datos.ranking);
          $("#form-crear-editar-jugador-especialidad").val(
            respuesta.datos.especialidad
          );
          $("#form-crear-editar-jugador-bloqueado").prop(
            "checked",
            respuesta.datos.bloqueado
          );
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
  $("#modal-crear-editar-jugador").modal("show");
}

function guardarJugador(boton) {
  const form = $("#form-crear-editar-jugador").get(0);

  $(".form-control").removeClass("is-invalid");
  $("#form-crear-editar-jugador-feedback").removeClass(
    "text-bg-danger text-bg-success"
  );
  $("#form-crear-editar-jugador-feedback").html("");

  let formData = new FormData(form);
  formData.append("tarea", "GUARDAR_JUGADOR");
  formData.set(
    "bloqueado",
    $("#form-crear-editar-jugador-bloqueado").prop("checked")
  );

  $.ajax({
    url: RUTA_URL_API + "/api.jugador.php",
    method: "POST",
    data: formData, // Enviar el objeto FormData
    contentType: false, // No establecer el encabezado Content-Type manualmente
    processData: false, // No procesar los datos (necesario para FormData)

    success: function (respuesta) {
      if (respuesta.exito === 0) {
        $("#form-crear-editar-jugador-feedback").addClass("text-bg-danger");
        $("#form-crear-editar-jugador-feedback").html(respuesta.mensaje);

        if (respuesta.errorEmail == 1) {
          $("#form-crear-editar-jugador-email").addClass("is-invalid");
        }
        if (respuesta.errorPassword == 1) {
          $("#form-crear-editar-jugador-password1").addClass("is-invalid");
          $("#form-crear-editar-jugador-password2").addClass("is-invalid");
        }
        if (respuesta.errorNombreApellidos == 1) {
          $("#form-crear-editar-jugador-nombre").addClass("is-invalid");
          $("#form-crear-editar-jugador-apellidos").addClass("is-invalid");

        }
      }

      if (respuesta.exito === 1) {
        $("#modal-crear-editar-jugador").modal("hide");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      alert("Ocurrió un error al enviar el formulario");
    },
  });
}
