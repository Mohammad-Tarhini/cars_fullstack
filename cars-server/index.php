<?php 
require_once("./services/ResponseService.php");
require_once("./routes/api.php");

$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}

if ($request == '') {
    $request = '/';
}

//array of routes - a mapping between routes and controller name and method!
//remove routes from here!! 
$apis = [
    '/cars/getCarByID'         => ['controller' => 'CarController', 'method' => 'getCarByID'],
    '/cars/getAllCars'         => ['controller' => 'CarController', 'method' => 'getAllCars'],
    '/cars/deleteCarById'     =>['controller'=>'CarController' ,'method'=>'deleteCarById'],
    '/cars/addCar'           =>['controller'=>'CarController' , 'method'=>'addCar'],
    '/cars/updateCar'        =>['controller'=>'CarController' ,'method'=>'updateCar']
];


if (isset($apis[$request])) {
    $controller_name = $apis[$request]['controller']; 
    $method = $apis[$request]['method'];
    require_once "controllers/{$controller_name}.php";
    
    $controller = new $controller_name();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo ResponseService::response(500, "Error: Method {$method} not found in {$controller_name}");
    }
} else {
    echo ResponseService::response(404, "Route Not Found");
}