<?php
namespace Model;
use PDO;
class ActiveRecord {

    // Variables para uso de base de datos
    protected static $database;
    protected static $tabla = '';
    protected static $columns = [];
    protected static $idTable = '';

   
    // Alerts y Mensajes
    protected static $alerts = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$database = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alerts[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlerts() {
        return static::$alerts;
    }

    public function validar() {
        static::$alerts = [];
        return static::$alerts;
    }

    // Registros - CRUD
   // public function guardar() {
   //     $resultado = '';
   //     $id = static::$idTable ?? 'id';
   //     if(!is_null($this->$id)) {
   //         // actualizar
   //         $resultado = $this->actualizar();
   //     } else {
   //         // Creando un nuevo registro
   //         $resultado = $this->crear();
   //     }
   //     return $resultado;
   // }

   // Busca todos los registros de una tabla
    public static function php_FindAll() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        // debuguear($resultado);
        return $resultado;
    }
    

    // Busca un registro por su id
    public static function find($id) {
        $idQuery = static::$idTable ?? 'id';
        $query = "SELECT * FROM " . static::$tabla  ." WHERE $idQuery = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registro con un limite obtenido de registros
    public static function php_FindWithLimit($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Busqueda Where con Columna 
    public static function php_FindWithWhere($columna, $valor, $condicion = '=') {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} ${condicion} '${valor}'";
        $resultado = self::consultarSQL($query);
        return  $resultado ;
    }

    // SQL para Consultas Avanzadas.
    public static function php_Query($consulta) {
        $query = $consulta;
        $resultado = self::$database->query($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ("; 
        $query .= join(", ", array_values($atributos));
        $query .= " ) ";
        

        // Resultado de la consulta
        $resultado = self::$database->exec($query);

        return [
           'resultado' =>  $resultado,
           'id' => self::$database->lastInsertId(static::$tabla)
        ];
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}={$value}";
        }
        $id = static::$idTable ?? 'id';

        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE " . $id . " = " . self::$database->quote($this->$id) . " ";

        // debuguear($query);

        $resultado = self::$database->exec($query);
        return [
            'resultado' =>  $resultado,
        ];
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar() {
        $query = "UPDATE "  . static::$tabla . " SET situacion = 0 WHERE id = " . self::$database->quote($this->id);
        $resultado = self::$database->exec($query);
        return $resultado;
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$database->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $array[] = static::php_CreateObject($registro);
        }

        // liberar la memoria
        $resultado->closeCursor();

        // retornar los resultados
        return $array;
    }

    public static function fetchArray($query){
        $resultado = self::$database->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = array_change_key_case( array_map( 'utf8_encode', $value) ); 
        }
        $resultado->closeCursor();
        return $data;
    }

        
    public static function fetchFirst($query){
        $resultado = self::$database->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = array_change_key_case( array_map( 'utf8_encode', $value) ); 
        }
        $resultado->closeCursor();
        return array_shift($data);
    }

    protected static function php_CreateObject($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            $key = strtolower($key);
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = utf8_encode($value);
            }
        }

        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDataBase as $columna) {
            $columna = strtolower($columna);
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$database->quote($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}