function enviarFormularioLogin(event) {
  const form = event.target;

  $(".form-control").removeClass("is-invalid is-valid");
  $("#form-login-feedback").removeClass("text-bg-danger text-bg-success");
  $("#form-login-feedback").html("");

  let formData = new FormData(form);
  formData.append("tarea", "VALIDAR_LOGIN");

  $.ajax({
    url: RUTA_URL_API + "/api.login.php",
    method: "POST",
    data: formData, // Enviar el objeto FormData
    contentType: false, // No establecer el encabezado Content-Type manualmente
    processData: false, // No procesar los datos (necesario para FormData)

    success: function (respuesta) {
      if (respuesta.exito === 0) {
        $("#form-login-usuario").addClass("is-invalid");
        $("#form-login-password").addClass("is-invalid");
        $("#form-login-feedback").addClass("text-bg-danger");
        $("#form-login-feedback").html(respuesta.mensaje);
      }

      if (respuesta.exito === 1) {
        window.location.href = RUTA_URL_PRINCIPAL + "/index.php";
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud:", error);
      alert("Ocurrió un error al enviar el formulario");
    },
  });
}
