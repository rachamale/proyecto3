<?php

namespace Model;

//Tabla de base de datos califiacacion
class Calificacion extends ActiveRecord{
    public static $tabla = 'calificaciones';
    public static $columnasDB = ['calif_alumno','calif_materia','calif_punteo','calif_resultado','detalle_situacion'];
    public static $idTabla = 'id_calificaciones';

    public $calificacion_id;
    public $calificacion_alumno;
    public $calificacion_materia;
    public $calificacion_punteo;
    public $calificacion_resultado;
    public $detalle_situacion;

    public function __construct($args =[])
    {
        $this->calificacion_id = $args['id_calificaciones'] ?? null;
        $this->calificacion_alumno = $args['calificacion_alumno'] ?? '';
        $this->calificacion_materia = $args['calificacion_materia'] ?? '';
        $this->calificacion_punteo = $args['calificacion_punteo'] ?? '';
        $this->calificacion_resultado = $args['calificacion_resultado'] ?? '';
        $this->detalle_situacion = $args['detalle_situacion'] ?? '1';
    }

}