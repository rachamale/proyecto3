<?php

namespace Controllers;
use Exception;
use Model\Calificacion;
use MVC\Router;

class ReporteController{
    public static function index(Router $router) {
        // se declara una variable para alamcenar
        $calificaciones = static::calificaciones();
     
        $router->render('reportes/index', [
           
            'calificaciones' => $calificaciones
            
       ]);
     
    
    }
    public static function buscarApi()
    {

   
        
        $id = $_GET['id_asignacion'];

    
        try {
            
                    $sql = "SELECT
                    DISTINCT id_alumnos, a.alu_nombre || ' ' || a.alu_apellido AS nombre_alumno,
                    a.alu_grado || ' de ' || a.alu_arma AS grado_y_arma,
                    a.alu_nac AS nacionalidad,
                    m.ma_nombre AS materia,
                    c.calif_punteo AS punteo,
                    c.calif_resultado AS resultado
                FROM
                    calificaciones c
                JOIN
                    alumnos a ON c.calif_alumno = a.id_alumnos
                JOIN
                    materias m ON c.calif_materia = m.id_materias
                WHERE
                    c.detalle_situacion = '1';
                 and  alumno_id = $id
                ";
          
            $reportes = Reporte::fetchArray($sql);
    
            echo json_encode($reportes);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    

 

    
    
    
    // se crea una funcion statica que mande a traer todo
    public  static function calificaciones()
    {
     
        $sql = "SELECT
        c.id_calificaciones,
        a.alu_nombre || ' ' || a.alu_apellido AS nombre_alumno
    FROM
        calificaciones c
    JOIN
        alumnos a ON c.calif_alumno = a.id_alumnos;
    ";        
              
    
                     
        try {
            
            $calificaciones = Calificacion::fetchArray($sql);
            // var_dump($asignaciones);
            // exit;
 
            if ($calificaciones){
                
                return $calificaciones; 
            }else {
                return 0;
            }
        } catch (Exception $e) {
            
        }
    }  


  
}