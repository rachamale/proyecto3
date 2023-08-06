<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\AlumnoController;
// use Controllers\MateriaController;
// use Controllers\CalificacionController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);
//ruta para la pagina de inicio de la aplicacion
$router->get('/', [AppController::class,'index']);

// ruta para mostrar listado de alumnos
$router->get('/alumnos', [AlumnoController::class,'index'] );
//rutas para crear,actulizar,eliminar y buscar un nuevo alumno mediante una solicitud Post a la api,y get el api_read
$router->post('/API/alumnos/guardar', [AlumnoController::class,'API_CREATE'] );
$router->post('/API/alumnos/modificar', [AlumnoController::class,'API_UPDATE'] );
$router->post('/API/alumnos/eliminar', [AlumnoController::class,'API_DELETE'] );
$router->get('/API/alumnos/buscar', [AlumnoController::class,'API_READ'] );

// //Ruta para mostrar el listado de materias.
// $router->get('/materias', [MateriaController::class,'index'] );
// //rutas para crear,actulizar,eliminar y buscar una nueva materia mediante una solicitud Post a la api,y get el api_read
// $router->post('/API/materias/guardar', [MateriaController::class,'API_CREATE'] );
// $router->post('/API/materias/modificar', [MateriaController::class,'API_UPDATE'] );
// $router->post('/API/materias/eliminar', [MateriaController::class,'API_DELETE'] );
// $router->get('/API/materias/buscar', [MateriaController::class,'API_READ'] );

// // Ruta para mostrar el listado de calificaciones.
// $router->get('/calificaciones', [AlumnoController::class,'index'] );
// //rutas para crear,actulizar,eliminar y buscar una nueva calificacion mediante unsa solicitud Post a la api,y get el api_read
// $router->post('/API/calificaciones/guardar', [CalificacionController::class,'API_CREATE'] );
// $router->post('/API/calificaciones/modificar', [CalificacionController::class,'API_UPDATE'] );
// $router->post('/API/calificaciones/eliminar', [CalificacionController::class,'API_DELETE'] );
// $router->get('/API/calificaciones/buscar', [CalificacionController::class,'API_READ'] );

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
