function enviarFormularioCambiarPassword(event) {
    const form = event.target
    $(".form-control").removeClass("is-invalid is-valid");
    $("#form-cambiarPassword-feedback").removeClass("text-bg-danger text-bg-success");
    $("#form-cambiarPassword-feedback").html("");
  
    let formData = new FormData(form);
    formData.append("tarea", "CAMBIAR_PASSWORD");
  
    $.ajax({
      url: RUTA_URL_API + "/api.cambiarPassword.php",
      method: "POST",
      data: formData, 
      contentType: false, 
      processData: false, 
  
      success: function (respuesta) {
        if (respuesta.exito === 0) {
          $("#form-cambiarPassword-passwordActual").addClass("is-invalid");
          $("#form-cambiarPassword-passwordNueva").addClass("is-invalid");
          $("#form-cambiarPassword-repetirPasswordNueva").addClass("is-invalid");
          $("#form-cambiarPassword-feedback").addClass("text-bg-danger");
        }
  
        if (respuesta.exito === 1) {
          $("#form-cambiarPassword-passwordActual").addClass("is-valid");
          $("#form-cambiarPassword-passwordNueva").addClass("is-valid");
          $("#form-cambiarPassword-repetirPasswordNueva").addClass("is-valid");
          $("#form-cambiarPassword-feedback").addClass("text-bg-success")
        }
        $("#form-cambiarPassword-feedback").html(respuesta.mensaje);
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud:", error);
        alert("Ocurrió un error al cambiar la contraseña");
      },
    });
  }
  