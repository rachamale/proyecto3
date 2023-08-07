<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\AlumnoController;
use Controllers\MateriaController;
use Controllers\CalificacionController;
use Controllers\ReporteController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);
//ruta para la pagina de inicio de la aplicacion
$router->get('/', [AppController::class,'index']);

// ruta para mostrar listado de alumnos
$router->get('/alumnos', [AlumnoController::class,'index'] );
//rutas para crear,actulizar,eliminar y buscar un nuevo alumno mediante una solicitud Post a la api,y get el buscarAPI
$router->post('/API/alumnos/guardar', [AlumnoController::class,'guardarAPI'] );
$router->post('/API/alumnos/modificar', [AlumnoController::class,'modificarAPI'] );
$router->post('/API/alumnos/eliminar', [AlumnoController::class,'eliminarAPI'] );
$router->get('/API/alumnos/buscar', [AlumnoController::class,'buscarAPI'] );

//Ruta para mostrar el listado de materias.
$router->get('/materias', [MateriaController::class,'index'] );
//rutas para crear,actulizar,eliminar y buscar una nueva materia mediante una solicitud Post a la api,y get el buscarAPI
$router->post('/API/materias/guardar', [MateriaController::class,'guardarAPI'] );
$router->post('/API/materias/modificar', [MateriaController::class,'modificarAPI'] );
$router->post('/API/materias/eliminar', [MateriaController::class,'eliminarAPI'] );
$router->get('/API/materias/buscar', [MateriaController::class,'buscarAPI'] );

$router->get('/reporte', [ReporteController::class,'index'] );

// Ruta para mostrar el listado de calificaciones.
$router->get('/calificaciones', [CalificacionController::class,'index'] );
//rutas para crear,actulizar,eliminar y buscar una nueva calificacion mediante unsa solicitud Post a la api,y get el buscarAPI
$router->post('/API/calificaciones/guardar', [CalificacionController::class,'guardarAPI'] );
$router->post('/API/calificaciones/modificar', [CalificacionController::class,'modificarAPI'] );
$router->post('/API/calificaciones/eliminar', [CalificacionController::class,'eliminarAPI'] );
$router->get('/API/calificaciones/buscar', [CalificacionController::class,'buscarAPI'] );

$router->get('/reportes', [ReporteController::class,'index'] );
$router->get('/API/reportes/buscar', [ReporteController::class,'buscarAPI'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
