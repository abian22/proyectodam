function abrirModalEntrenador(boton, id) {
    $("#form-crear-editar-entrenador-id").val(id);

    $(".form-control").removeClass("is-invalid");
    $("#form-crear-editar-entrenador-feedback").removeClass("text-bg-danger text-bg-success");
    $("#form-crear-editar-entrenador-feedback").html('');

    if (id > 0) {
        $(".form-control").val('');

        let formData = new FormData();
        formData.append('tarea', 'CARGAR_ENTRENADOR');
        formData.append('id', $("#form-crear-editar-entrenador-id").val());

        $.ajax({
            url: RUTA_URL_API + '/api.entrenador.php',
            method: 'POST',
            data: formData, // Enviar el objeto FormData
            contentType: false, // No establecer el encabezado Content-Type manualmente
            processData: false, // No procesar los datos (necesario para FormData)

            success: function (respuesta) {
                if (respuesta.exito === 0) {
                    alert(respuesta.mensaje);
                }

                if (respuesta.exito === 1) {
                    $("#form-crear-editar-entrenador-nombre").val(respuesta.datos.nombre);
                    $("#form-crear-editar-entrenador-apellidos").val(respuesta.datos.apellidos);
                    $("#form-crear-editar-entrenador-email").val(respuesta.datos.email);

                    $("#form-crear-editar-entrenador-bloqueado").prop('checked', respuesta.datos.bloqueado);

                    $("#modal-crear-editar-entrenador").modal("show");
                }
            }
            ,

            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                alert('Ocurrió un error al enviar el formulario');
            }
        });
    } else {
        $(".form-control").val('');
        $("#modal-crear-editar-entrenador").modal("show");
    }
}


function guardarEntrenador(boton) {
    const form = $("#form-crear-editar-entrenador").get(0);

    $(".form-control").removeClass("is-invalid");
    $("#form-crear-editar-entrenador-feedback").removeClass("text-bg-danger text-bg-success");
    $("#form-crear-editar-entrenador-feedback").html('');

    let formData = new FormData(form);
    formData.append('tarea', 'GUARDAR_ENTRENADOR');
    formData.set('bloqueado', $("#form-crear-editar-entrenador-bloqueado").prop('checked'));

    $.ajax({
        url: RUTA_URL_API + '/api.entrenador.php',
        method: 'POST',
        data: formData, // Enviar el objeto FormData
        contentType: false, // No establecer el encabezado Content-Type manualmente
        processData: false, // No procesar los datos (necesario para FormData)

        success: function (respuesta) {
            if (respuesta.exito === 0) {
                $("#form-crear-editar-entrenador-feedback").addClass('text-bg-danger');
                $("#form-crear-editar-entrenador-feedback").html(respuesta.mensaje);

                if (respuesta.errorEmail == 1) {
                    $("#form-crear-editar-entrenador-email").addClass('is-invalid');
                }

                if (respuesta.errorPassword == 1) {
                    $("#form-crear-editar-entrenador-password1").addClass('is-invalid');
                    $("#form-crear-editar-entrenador-password2").addClass('is-invalid');
                }

                if (respuesta.errorNombreApellidos == 1) {
                    $("#form-crear-editar-entrenador-nombre").addClass('is-invalid');
                    $("#form-crear-editar-entrenador-apellidos").addClass('is-invalid');
                }
                if (respuesta.errorJuego == 1) {
                    $("#form-crear-editar-entrenador-juego").addClass('is-invalid');
               
                }
                if (respuesta.errorEspecialidad == 1) {
                    $("#form-crear-editar-entrenador-especialidad").addClass('is-invalid');
                   
                }
            }

            if (respuesta.exito === 1) {
                $("#modal-crear-editar-entrenador").modal("hide");
            }
        }
        ,

        error: function (xhr, status, error) {
            console.error('Error en la solicitud:', error);
            alert('Ocurrió un error al enviar el formulario');
        }
    });

}