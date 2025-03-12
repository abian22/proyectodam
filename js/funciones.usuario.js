function cambiarPasswordUsuario(event) {
    const form = event.target;

    $(".form-control").removeClass("is-invalid is-valid");
    $("#form-cambio-password-feedback").removeClass("text-bg-danger text-bg-success");
    $("#form-cambio-password-feedback").html('');

    let formData = new FormData(form);
    formData.append('tarea', 'CAMBIAR_PASSWORD');

    $.ajax({
        url: RUTA_URL_API + '/api.usuario.php',
        method: 'POST',
        data: formData, // Enviar el objeto FormData
        contentType: false, // No establecer el encabezado Content-Type manualmente
        processData: false, // No procesar los datos (necesario para FormData)

        success: function (respuesta) {
                    if (respuesta.exito === 0) {
                        $("#form-cambio-password-password-actual").addClass("is-invalid");
                        $("#form-cambio-password-password-1").addClass("is-invalid");
                        $("#form-cambio-password-password-2").addClass("is-invalid");

                        $("#form-cambio-password-feedback").addClass("text-bg-danger");
                        $("#form-cambio-password-feedback").html(respuesta.mensaje);
                    }

                    if (respuesta.exito === 1) {
                        $("#form-cambio-password-feedback").addClass("text-bg-success");
                        $("#form-cambio-password-feedback").html(respuesta.mensaje);
                    }
                }
        ,

        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
            alert('Ocurrió un error al enviar el formulario');
        }
    });
}