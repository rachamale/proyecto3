<?php

namespace Controllers;

use Exception;
use Model\Alumno;
use MVC\Router;

class AlumnoController{

    public static function index(Router $router){
        // echo "<script>console.log('alumnoController');</script>";
        $alumnos = Alumno::all();  
        // echo "<script>console.log('".$router->."');</script>";
        //   echo "<script>console.log('".$alumnos."');</script>";  
          $router->render('alumnos/index', [
            'alumnos' => $alumnos
          ]);


}

    public static function guardarAPI(){
        try {
            $alumno = new Alumno($_POST);
            $resultado = $alumno->crear();

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

    public static function modificarAPI(){
        try {
            $alumno = new Alumno($_POST);
            
            $resultado = $alumno->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrió un error OK',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error FATAL',
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI(){

        try {       
            $id_alumnos = $_POST['id_alumnos'];
            $alumno = Alumno::find($id_alumnos);
            
            $alumno->detalle_situacion = 0;
            $resultado = $alumno->actualizar();

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

    public static function buscarAPI() {
        try {
            $alu_nombre = isset($_GET['alu_nombre']) ? $_GET['alu_nombre'] : '';
            $alu_apellido = isset($_GET['alu_apellido']) ? $_GET['alu_apellido'] : '';
    
            $sql = "SELECT * FROM alumnos WHERE detalle_situacion = 1 ";
            $params = [];
    
            if (!empty($alu_nombre)) {
                $sql .= " AND alu_nombre LIKE '%" . $alu_nombre . "%'";
            }
    
            if (!empty($alu_apellido)) {
                $sql .= " AND alu_apellido LIKE '%" . $alu_apellido . "%'";
            }
    
            $alumnos = Alumno::fetchArray($sql, $params);
    
            echo json_encode($alumnos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}