<!-- Modal: Crear/Editar jugador -->
<div class="modal fade" id="modal-crear-editar-jugador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-bandaid"></i> Añadir/Editar jugador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="form-crear-editar-jugador">
                            <input type="hidden" id="form-crear-editar-jugador-id" name="id" value="0">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-jugador-nombre" name="nombre" placeholder="nombre">
                                        <label for="form-crear-editar-jugador-nombre">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-jugador-apellidos" name="apellidos" placeholder="apellidos">
                                        <label for="form-crear-editar-jugador-apellidos">Apellidos</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="form-crear-editar-jugador-email" name="email" placeholder="email">
                                        <label for="form-crear-editar-jugador-email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="juego" class="form-control" id="form-crear-editar-jugador-juego" name="juego" placeholder="juego">
                                        <label for="form-crear-editar-jugador-juego">Juego</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="ranking" class="form-control" id="form-crear-editar-jugador-ranking" name="ranking" placeholder="ranking">
                                        <label for="form-crear-editar-jugador-ranking">Ranking</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="especialidad" class="form-control" id="form-crear-editar-jugador-especialidad" name="especialidad" placeholder="especialidad">
                                        <label for="form-crear-editar-jugador-especialidad">Especialidad</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="form-crear-editar-jugador-password1" name="password1" placeholder="Contraseña">
                                        <label for="form-crear-editar-jugador-password1">Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="form-crear-editar-jugador-password2" name="password2" placeholder="Repetir contraseña">
                                        <label for="form-crear-editar-jugador-password2">Repetir contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="form-crear-editar-jugador-bloqueado" name="bloqueado">
                                        <label class="form-check-label" for="form-crear-editar-jugador-bloqueado">Bloqueado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="mb-3">
                                        <span class="badge" id="form-crear-editar-jugador-feedback"></span>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarJugador(this)"> <i class="bi bi-cloud-arrow-up"></i> Guardar Datos</button>
            </div>
        </div>
    </div>
</div>