<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__."/../services/CarServices.php");


class CarController {

        function getCarByID(){
        global $connection;

        if(isset($_GET["id"])){
            $id = $_GET["id"];
        }else{
            echo ResponseService::response(500, "ID is missing");
            return;
        }

        //not allowed to write logic in my controller!!!
        //$car = Car::find($connection, $id);
        //$car = $car ? $car->toArray() : [];
        $car = CarService::findCarByID($id);
        echo ResponseService::response(200, $car);
        return;
    }
    function getAllCars(){
        global $connection;
        $cars=Car::findAll($connection);
        if ($cars && count($cars) > 0) {
        echo ResponseService::response(200, $cars);
    } else {
        echo ResponseService::response(404, "No cars found");
    }

    }

    function deleteCarById(){
        global $connection;
        if(isset($_GET["id"])){
            $id = $_GET["id"];
        }else{
            echo ResponseService::response(500, "ID is missing");
            return;
        }
       $result= CarServices::deleteByIdHelper($connection,$id);
       echo ResponseService::response($result["num"],$result["message"]);
    }
    function deleteCar(){

    }
    function addCar(){
         global $connection;
          if (!isset($_POST['name'], $_POST['year'], $_POST['color'])) {
        echo ResponseService::response(400, "Missing data");
        return;
         }
         $name = $_POST['name'];
          $year = $_POST['year'];
          $color = $_POST['color'];

        $car = new Car([
        
        'name'  => $name,
        'year'  => $year,
        'color' => $color
        ]);
         if ($car->insert($connection)) {
        echo ResponseService::response(200, "Car added successfully");
        } else {
        echo ResponseService::response(400, "There was a problem");
        }
    }



    function updateCar() {
    global $connection;  

    
    if (empty($_POST["id"])) {
        echo ResponseService::response(500, "Enter ID please");
        return;
    }

    $id = $_POST["id"];
    $newName  = $_POST["new_name"]  ?? null;
    $newYear  = $_POST["new_year"]  ?? null;
    $newColor = $_POST["new_color"] ?? null;

    
    $car = Car::find($connection, $id);

    if (!$car) {
        echo ResponseService::response(404, "Car not found");
        return;
    }

    
    if ($newName)  $car->name  = $newName;
    if ($newYear)  $car->year  = $newYear;
    if ($newColor) $car->color = $newColor;

    
    if ($car->update($connection)) {
        echo ResponseService::response(200, "Excellent");
    } else {
        echo ResponseService::response(400, "Not updated");
    }
}
}
?>