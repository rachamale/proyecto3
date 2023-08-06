<?php

namespace Controllers;

use Exception;
use Model\Alumno;
use MVC\Router;

class AlumnoController{
    public static function index(Router $router){
        $alumnos = Alumno::php_FindAll();
        $router->render('alumnos/index', ['alumnos' => $alumnos]);

    }

    public static function API_CREATE(){
        try {
            $alumno = new Alumno($_POST);
            $resultado = $alumno->php_Create();

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

    public static function API_UPDATE(){
        try {
            $alumno = new Alumno($_POST);
            
            $resultado = $alumno->php_Update();

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

    public static function API_DELETE(){
        try {
            $alumno_id = $_POST['alumno_id'];
            $alumno = Alumno::php_FindById($alumno_id);
            $alumno->detalle_situacion = 0;
            $resultado = $alumno->php_Delete();

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

    public static function API_READ(){
        // $alumnos = Alumno::all();
        $alumno_nombre = $_GET['alu_nombre'];
        $alumno_apellido = $_GET['alu_apellido'];

        $sql = "SELECT * FROM alumnos where detalle_situacion = 1 ";
        if($alumno_nombre != '') {
            $sql.= " and alu_nombre like '%$alumno_nombre%' ";
        }
        if($alumno_apellido != '') {
            $sql.= " and alu_apellido = $alumno_apellido ";
        }
        try {
            
            $alumnos = Alumno::fetchArray($sql);
    
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