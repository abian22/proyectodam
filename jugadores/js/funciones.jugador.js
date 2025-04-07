function abrirModalJugador(boton, id) {
  $("#form-crear-editar-jugador-id").val(id);

  $(".form-control").removeClass("is-invalid");
  $("#form-crear-editar-jugador-feedback").removeClass(
    "text-bg-danger text-bg-success"
  );
  $("#form-crear-editar-jugador-feedback").html("");

  if (id > 0) {
    $(".form-control").val("");

    let formData = new FormData();
    formData.append("tarea", "CARGAR_JUGADOR");
    formData.append("id", $("#form-crear-editar-jugador-id").val());

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
          $("#form-crear-editar-jugador-especialidad").val(
            respuesta.datos.especialidad
          );
          $("#form-crear-editar-jugador-imagenPerfil").val(
            respuesta.datos.imagenPerfil
          );

          $("#form-crear-editar-jugador-bloqueado").prop(
            "checked",
            respuesta.datos.bloqueado
          );

          $("#modal-crear-editar-jugador").modal("show");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error al enviar el formulario");
      },
    });
  } else {
    $(".form-control").val("");
    $("#modal-crear-editar-jugador").modal("show");
  }
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
        if (respuesta.errorJuego == 1) {
          $("#form-crear-editar-jugador-juego").addClass("is-invalid");
        }
        if (respuesta.errorEspecialidad == 1) {
          $("#form-crear-editar-jugador-especialidad").addClass("is-invalid");
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

function abrirModalSesionJugador(boton, id) {
  $("#form-crear-editar-sesion-jugador-id").val(id);

  $(".form-control").removeClass("is-invalid");
  $(".form-control").val("");
  $("#form-crear-editar-sesion-jugador-feedback").removeClass(
    "text-bg-danger text-bg-success"
  );
  $("#form-crear-editar-sesion-jugador-feedback").html("");

  if (id > 0) {
    let formData = new FormData();
    formData.append("tarea", "CARGAR_SESION");
    formData.append("id", $("#form-crear-editar-sesion-jugador-id").val());
    $.ajax({
      url: RUTA_URL_API + "/api.sesion.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (respuesta) {
        if (respuesta.exito === 0) {
          alert(respuesta.mensaje);
        }

        if (respuesta.exito === 1) {
          $.each(respuesta.datos, function (campo, valor) {
            $("#form-crear-editar-sesion-jugador-" + campo).val(valor);
          });

          $("#modal-crear-editar-sesion-jugador").modal("show");
        }

        if (respuesta.errorObjetivo == 1) {
          $("#form-crear-editar-jugador-objetivo").addClass("is-invalid");
        }

        if (respuesta.errorProceso == 1) {
          $("#form-crear-editar-jugador-proceso").addClass("is-invalid");
        }
      },

      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error al enviar el formulario");
      },
    });
  } else {
    $(".form-control").val("");
    $("#modal-crear-editar-sesion-jugador").modal("show");
  }
}

function guardarSesionJugador(boton) {
  const form = $("#form-crear-editar-sesion-jugador").get(0);

  $(".form-control").removeClass("is-invalid");
  $("#form-crear-editar-cita-jugador-feedback").removeClass(
    "text-bg-danger text-bg-success"
  );
  $("#form-crear-editar-cita-jugador-feedback").html("");

  let formData = new FormData(form);
  formData.append("tarea", "GUARDAR_SESION");
  formData.append("idJugador", $("#idJugador").val());

  $.ajax({
    url: RUTA_URL_API + "/api.sesion.php",
    method: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (respuesta) {
      if (respuesta.exito === 0) {
        if (respuesta.errorFecha == 1) {
          $("#form-crear-editar-sesion-jugador-fechaHora").addClass(
            "is-invalid"
          );
        }
        $("#form-crear-editar-sesion-jugador-feedback").addClass(
          "text-bg-danger"
        );
        $("#form-crear-editar-sesion-jugador-feedback").html(respuesta.mensaje);
      }

      if (respuesta.exito === 1) {
        $("#modal-crear-editar-sesion-jugador").modal("hide");
        location.reload();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      alert("Ocurrió un error al enviar el formulario");
    },
  });
}

function eliminarSesionJugador(boton, id) {
  if (!confirm("¿Está seguro de que desea eliminar la cita?")) {
    return false;
  }

  let formData = new FormData();
  formData.append("tarea", "ELIMINAR_SESION");
  formData.append("id", id);

  $.ajax({
    url: RUTA_URL_API + "/api.sesion.php",
    method: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (respuesta) {
      if (respuesta.exito === 0) {
        alert(respuesta.mensaje);
      }

      if (respuesta.exito === 1) {
        location.reload();
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      alert("Ocurrió un error al enviar el formulario");
    },
  });
}
