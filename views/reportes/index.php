
<h1 class="text-center">Busqueda de calificaciones</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioReportes">

        <div class="col">
            <label for="calif_alumno">Alumno</label>
            <select class="form-control" name="calificacion_asignacion" id="calificacion_asignacion">
                <option value="">Selecione un alumno </option>
                <?php foreach ($calificaciones as $calificacion) { ?>
                    <option value="<?= $calificacion['id_calificaciones'] ?>">
                        <?= $calificacion['nombre_alumno'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <button type="button" form="formularioReportes" id="btnBuscar" data-saludo="hola" data-saludo2="hola2" class="btn btn-primary w-100">Buscar</button>
            </div>

        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-8">

    <table class="table table-bordered table-hover" id="tablaReportes" style="border: 1px solid black;">
    <thead class="table-dark">
        <tr>
            <th style="border: 1px solid black;">NOMBRE ALUMNO</th>
            <th id="nombre" colspan="3"></th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">GRADO Y ARMA</th>
            <th id="grado" colspan="3"></th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">NACIONALIDAD</th>
            <th id="nacionalidad" colspan="3"></th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center; border: 1px solid black;">NOTAS OBTENIDAS</th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">NO.</th>
            <th style="border: 1px solid black;">MATERIA</th>
            <th style="border: 1px solid black;">PUNTEO</th>
            <th style="border: 1px solid black;">GANO/PERDIO</th>
        </tr>
    </thead>
    <tbody>
     
        </tbody>
        <tr>
            <th>PROMEDIO</th>
            <th colspan="3" id="promedio"></th>
        </tr>
</table>



    </div>
</div>
<script src="<?= asset('./build/js/reportes/index.js')  ?>"></script>