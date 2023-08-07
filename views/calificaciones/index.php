<h1 class="text-center">Ingreso de las calificaciones</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioCalificaciones">

    <div class="row mb-3" hidden >
            <div class="col">
                <label for="id_calificaciones">Codigo Alumno</label>
                <input  step="0.01" min="0" name="id_calificaciones" id="id_calificaciones" class="form-control" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="calif_alumno">Nombre del Alumno</label>
                <!-- <input type="number" name="calif_alumno" id="calif_alumno" class="form-control"> -->
                <select class="form-control" name="calif_alumno" id="calif_alumno">
                    <option value="">Seleccione un nombre de alumno...</option>
                    <?php foreach ($alumnos as $alumno) : ?>
                        <option value="<?= $alumno['id_alumnos'] ?>">
                            <?= $alumno['alu_nombre'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="calif_materia">Materia</label>
                <!-- <input type="number" step="0.01" min="0" name="calif_materia" id="calif_materia" class="form-control"> -->
                <select class="form-control" name="calif_materia" id="calif_materia">
                    <option value="">Seleccione una materia...</option>
                    <?php foreach ($materias as $materia) : ?>
                        <option value="<?= $materia['id_materias'] ?>">
                            <?= $materia['ma_nombre'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="calif_punteo">Nota</label>
                        <input type="float" step="0.01" min="0" name="calif_punteo" id="calif_punteo" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="calif_resultado">Resultado</label>
                        <input type="text" step="0.01" min="0" name="calif_resultado" id="calif_resultado" class="form-control">
                    </div>
                </div>
              
        <div class="row mb-3">
                    <div class="col">
                        <button type="submit" form="formularioCalificaciones" id="btnGuardar" data-saludo= "hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row justify-content-center" id="divTabla">
            <div class="col-lg-8">
                <h2>LISTADO DE CALIFICACIONES</h2>
                <table class="table table-bordered table-hover" id="tablaCalificaciones">
                    <thead class="table-dark">
                        <tr>
                            <th>NO. </th>
                            <th>ID ALUMNO</th>
                            <th>ID MATERIA</th>
                            <th>PUNTEO</th>
                            <th>RESULTADO</th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="<?= asset('./build/js/calificaciones/index.js')  ?>"></script>

