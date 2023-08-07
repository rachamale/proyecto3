<?php

namespace Controllers;

use Exception;
use Model\Alumno;
use Model\Materia;
use Model\Calificacion;
use MVC\Router;

//Método para mostrar la página de listado de calificaciones.
class CalificacionController{
    public static function index(Router $router){
        $calificaciones = Calificacion::All();
        $alumnos = static::buscarAlumnos();
        $materias = static::buscarMaterias();
        $router->render('calificaciones/index', [
            'calificaciones' => $calificaciones,
            'alumnos' => $alumnos,
            'materias' => $materias,
            // 'calificaciones2' => $calificaciones2,
        ]);
    }

/**
 * Método para crear una nueva calificación mediante la API.
 * Este método se utiliza para recibir datos enviados por una solicitud POST,
 * crear un nuevo objeto Calificacion y guardar la calificación en la base de datos.
 * Luego, envía una respuesta JSON indicando si la creación fue exitosa o si ocurrió un error.
 */
    public static function guardarAPI(){
        try {
            $calificacion = new Calificacion($_POST);
            $resultado = $calificacion->crear();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

/**
 * Método para actualizar una calificación mediante la API.
 * crear un nuevo objeto Calificacion a partir de los datos recibidos y actualizar la calificación correspondiente
 * en la base de datos.
 * Luego, envía una respuesta JSON indicando si la actualización fue exitosa o si ocurrió un error.
 */
public static function modificarAPI(){
    try {
        $calificacion = new Calificacion($_POST);
        
        $resultado = $calificacion->actualizar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                'mensaje' => 'Registro modificado correctamente',
                'codigo' => 1
            ]);
        }else{
            echo json_encode([
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}


/**
 * Método para eliminar una calificación mediante la API.
 * obtener el ID de la calificación a eliminar, marcar el registro con 'detalle_situacion' = 0
 * en la base de datos y enviar una respuesta JSON que indica si la eliminación fue exitosa o si ocurrió un error.
 */
public static function eliminarAPI(){
    try {
        $id_calificaciones = $_POST['id_calificaciones'];
        $calificacion = Calificacion::find($id_calificaciones);
        $calificacion->detalle_situacion = 0;
        $resultado = $calificacion->actualizar();

        if($resultado['resultado'] == 1){
            echo json_encode([
                'mensaje' => 'Registro eliminado correctamente',
                'codigo' => 1
            ]);
        }else{
            echo json_encode([
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

/**
 * Método para obtener una lista de calificaciones mediante la API.
 * Este método se utiliza para recibir datos enviados por una solicitud GET,
 * filtrar los registros de calificaciones en la base de datos según el alumno y materia proporcionados,
 * y enviar una respuesta JSON con la lista de calificaciones que coinciden con los criterios de búsqueda.
 */
public static function BuscarAPI(){
    $calificacion_alumno = isset($_GET['calif_alumno']) ? $_GET['calif_alumno'] : '';
    $calificacion_materia = isset($_GET['calif_materia']) ? $_GET['calif_materia'] : '';

    $sql = "SELECT * FROM calificaciones where detalle_situacion = 1 ";
    if (!empty($calificacion_alumno)) {
        $sql .= " AND calif_alumno = " . $calificacion_alumno . " ";
    }

    if (!empty($calificacion_materia)) {
        $sql .= " AND calif_materia = " . $calificacion_materia . " ";
    }
    try {
        
        $calificaciones = Calificacion::fetchArray($sql);

        echo json_encode($calificaciones);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function buscarAlumnos(){
    $sql = "SELECT * FROM alumnos where detalle_situacion = 1 ";
    try {
        $alumnos = Calificacion::fetchArray($sql); // Usar Calificaciones aquí
        return $alumnos;

       
    } catch (Exception $e) {
        // Manejo de excepciones aquí
        return[];
    }        
}

public static function buscarMaterias(){
    $sql = "SELECT * FROM materias where detalle_situacion = 1 ";
    try {
        $materias = Calificacion::fetchArray($sql); // Usar Calificaciones aquí
        return $materias;

    } catch (Exception $e) {
        // Manejo de excepciones aquí
        return[];
    }        
}

}