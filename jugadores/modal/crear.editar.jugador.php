<!-- Modal: Crear/Editar jugador -->
<div class="modal fade" id="modal-crear-editar-jugador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(135deg, #6f42c1, #007bff);">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-controller"></i> Añadir/Editar Jugador</h1>
                <button type="button"  class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="form-crear-editar-jugador">
                            <input type="hidden" id="form-crear-editar-jugador-id" name="id" value="0">
                            <div class="row">
                                <div class="mb-3 text-center">
                                    
                                    <label for="formFile" class="form-label">Elige una imagen de perfil (opcional)</label>
                                    <input type="file" class="form-control" id="form-crear-editar-jugador-imagenPerfil" name="imagenPerfil">
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-jugador-nombre" name="nombre" placeholder="Nombre">
                                        <label for="form-crear-editar-jugador-nombre">Nombre</label>
                                    </div>
                                </div>


                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-jugador-apellidos" name="apellidos" placeholder="Apellidos">
                                        <label for="form-crear-editar-jugador-apellidos">Apellidos</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="form-crear-editar-jugador-email" name="email" placeholder="Email">
                                        <label for="form-crear-editar-jugador-email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="form-crear-editar-jugador-juego" name="juego" placeholder="Juego">
                                            <option value="" disabled selected>Seleccione un juego</option>
                                            <?php
                                            $gestorDB = new HandlerDB();
                                            $sqlJuegos = "SELECT id, nombre FROM " . TABLA_JUEGOS;
                                            $stmtJuegos = $gestorDB->dbh->prepare($sqlJuegos);
                                            $stmtJuegos->execute();
                                            $juegos = $stmtJuegos->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($juegos as $juego) {
                                                echo '<option value="' . $juego['id'] . '">' . $juego['nombre'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="form-crear-editar-jugador-juego">Juego</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="form-crear-editar-jugador-especialidad" name="especialidad" placeholder="Especialidades">
                                            <option value="" disabled selected>Seleccione un juego para elegir especialidad</option>
                                            <?php
                                            $gestorDB = new HandlerDB();
                                            $sqlEspecialidades = "SELECT e.id, e.especialidad, e.juego_id
                                            FROM " . TABLA_ESPECIALIDAD . " e
                                            JOIN " . TABLA_JUEGOS . " j ON e.juego_id = j.id  
                                            WHERE e.rol_especialidad = 'JUGADOR'";
                                            $stmtEspecialidades = $gestorDB->dbh->prepare($sqlEspecialidades);
                                            $stmtEspecialidades->execute();
                                            $especialidades = $stmtEspecialidades->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($especialidades as $especialidad) {
                                                echo "<option value='{$especialidad['id']}' data-juego='{$especialidad['juego_id']}' style='display: none;'>";
                                                echo "{$especialidad['especialidad']}</option>";
                                            }
                                            ?>
                                        </select>
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
                                        <input type="password" class="form-control" id="form-crear-editar-jugador-password2" name="password2" placeholder="Repetir Contraseña">
                                        <label for="form-crear-editar-jugador-password2">Repetir Contraseña</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="form-crear-editar-jugador-bloqueado" name="bloqueado">
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
            <div class="modal-footer bg-dark-subtle">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarJugador(this)"><i class="bi bi-cloud-arrow-up"></i> Guardar Datos</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para actualizar especialidades dependiendo del juego -->
<script>
    document.getElementById("form-crear-editar-jugador-juego").addEventListener("change", function() {
        let juegoId = this.value;
        let especialidadSelect = document.getElementById("form-crear-editar-jugador-especialidad");

        let roles = especialidadSelect.querySelectorAll("option");
        roles.forEach(rol => {
            if (rol.getAttribute("data-juego") === juegoId) {
                rol.style.display = "block";
            } else {
                rol.style.display = "none";
            }
        });

        especialidadSelect.value = "";
    });
</script>