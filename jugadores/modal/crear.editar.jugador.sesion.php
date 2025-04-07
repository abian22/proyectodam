<?php
require_once __DIR__ . '/../../class/class.Usuario.php';

$entrenadores = listadoUsuarios(['id', 'apellidos', 'nombre'], 'ENTRENADOR');

$opcionesSelectEntrenadores = '';
foreach ($entrenadores as $entrenador) {
    $opcionesSelectEntrenadores .= '<option value="' . $entrenador['id'] . '">' . $entrenador['apellidos'] . ', ' . $entrenador['nombre'] . '</option>';
}
?>

<!-- Modal: Crear/Editar sesión jugador -->
<div class="modal fade" id="modal-crear-editar-sesion-jugador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(135deg, #6f42c1, #007bff);">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-bandaid"></i> Añadir/Editar sesión jugador</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="form-crear-editar-sesion-jugador">
                            <input type="hidden" id="form-crear-editar-sesion-jugador-id" name="id" value="0">

                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-floating mb-3">
                                        <input type="datetime-local" class="form-control" value="" id="form-crear-editar-sesion-jugador-fechaHora" name="fechaHora" placeholder="Fecha Hora">
                                        <label for="form-crear-editar-sesion-jugador-fechaHora">Fecha Hora</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-5">
                                    <div class="form-floating">
                                        <select class="form-select" id="form-crear-editar-sesion-jugador-idEntrenador" name="idEntrenador" aria-label="Floating label select example">
                                            <option value="0" selected>Seleccione un Entrenador</option>
                                            <?php echo $opcionesSelectEntrenadores; ?>
                                        </select>
                                        <label for="form-crear-editar-sesion-jugador-idEntrenador">Seleccionar Entrenador</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="mb-3">
                                        <span class="badge" id="form-crear-editar-sesion-jugador-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea style="height: 150px" class="form-control" placeholder="Objetivo" id="form-crear-editar-sesion-jugador-objetivo" name="objetivo"></textarea>
                                        <label for="form-crear-editar-sesion-jugador-objetivo">Objetivo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea style="height: 150px" class="form-control" placeholder="Proceso" id="form-crear-editar-sesion-jugador-proceso" name="proceso"></textarea>
                                        <label for="form-crear-editar-sesion-jugador-proceso">Proceso</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea style="height: 150px" class="form-control" placeholder="Observaciones" id="form-crear-editar-sesion-jugador-observaciones" name="observaciones"></textarea>
                                        <label for="form-crear-editar-sesion-jugador-observaciones">Observaciones</label>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark-subtle">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
                <button type="button" class="btn btn-success"  data-bs-dismiss="modal" onclick="guardarSesionJugador(this)"><i class="bi bi-cloud-arrow-up"></i> Guardar Datos</button>
            </div>
        </div>
    </div>
</div>