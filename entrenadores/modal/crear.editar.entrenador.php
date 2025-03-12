<!-- Modal: Crear/Editar entrenador -->
<div class="modal fade" id="modal-crear-editar-entrenador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-controller"></i> Añadir/Editar entrenador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="form-crear-editar-entrenador">
                            <input type="hidden" id="form-crear-editar-entrenador-id" name="id" value="0">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-entrenador-nombre" name="nombre" placeholder="Nombre">
                                        <label for="form-crear-editar-entrenador-nombre">Nombre</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-crear-editar-entrenador-apellidos" name="apellidos" placeholder="Apellidos">
                                        <label for="form-crear-editar-entrenador-apellidos">Apellidos</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="form-crear-editar-entrenador-email" name="email" placeholder="Email">
                                        <label for="form-crear-editar-entrenador-email">Email</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="form-crear-editar-entrenador-juego" name="juego" placeholder="Juego">
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
                                        <label for="form-crear-editar-entrenador-juego">Juego</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="form-crear-editar-entrenador-especialidad" name="especialidad" placeholder="Especialidad">
                                            <option value="" disabled selected>Seleccione un juego para elegir especialidad</option>
                                            <?php
                                            $gestorDB = new HandlerDB();
                                            $sqlEspecialidades = "SELECT id, especialidad, 
                                            CASE 
                                                WHEN id BETWEEN 16 AND 19 THEN 1 
                                                WHEN id BETWEEN 20 AND 23 THEN 2 
                                                ELSE 3 
                                            END AS juego_id
                                            FROM " . TABLA_ESPECIALIDAD . " 
                                            WHERE rol_especialidad = 'ENTRENADOR'";
                                            $stmtEspecialidades = $gestorDB->dbh->prepare($sqlEspecialidades);
                                            $stmtEspecialidades->execute();
                                            $especialidades = $stmtEspecialidades->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($especialidades as $especialidad) {
                                                echo "<option value='{$especialidad['id']}' data-juego='{$especialidad['juego_id']}' style='display: none;'>";
                                                echo "{$especialidad['especialidad']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="form-crear-editar-entrenador-especialidad">Especialidad</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="form-crear-editar-entrenador-password1" name="password1" placeholder="Contraseña">
                                        <label for="form-crear-editar-entrenador-password1">Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="form-crear-editar-entrenador-password2" name="password2" placeholder="Repetir Contraseña">
                                        <label for="form-crear-editar-entrenador-password2">Repetir Contraseña</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="form-crear-editar-entrenador-bloqueado" name="bloqueado">
                                        <label class="form-check-label" for="form-crear-editar-entrenador-bloqueado">Bloqueado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="mb-3">
                                        <span class="badge" id="form-crear-editar-entrenador-feedback"></span>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark-subtle">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
                <button type="button" class="btn btn-success" onclick="guardarEntrenador(this)"><i class="bi bi-cloud-arrow-up"></i> Guardar Datos</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para actualizar especialidades -->
<script>
    document.getElementById("form-crear-editar-entrenador-juego").addEventListener("change", function() {
        let juegoId = this.value;
        let especialidadSelect = document.getElementById("form-crear-editar-entrenador-especialidad");

        // Ocultar todas las opciones
        let roles = especialidadSelect.querySelectorAll("option");
        roles.forEach(rol => {
            if (rol.getAttribute("data-juego") === juegoId) {
                rol.style.display = "block";
            } else {
                rol.style.display = "none";
            }
        });

        // Resetear selección
        especialidadSelect.value = "";
    });
</script>