<?php
require_once("../models/Car.php");
require_once("../connection/connection.php");
require_once("../services/ResponseService.php");
require_once("../services/DeleteService.php");


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
        $cars=Car::findAll();
        if ($cars && count($cars) > 0) {
        echo ResponseService::response(200, $cars);
    } else {
        echo ResponseService::response(404, "No cars found");
    }

    }

    function deleteCarById(){
        globel $connection;
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
        echo ResponsiveServices::response(400, "Missing data");
        return;
         }
        $car=new car([$name,$year,$color]);
       if($car->insert($connection)){
        echo ResponsiveServices::response(200,"is added");
       }else{
        echo Responsive::response(400,"there is problem");
       }

        $car = new Car([
        'name'  => $name,
        'year'  => $year,
        'color' => $color
        ]);
         if ($car->insert($connection)) {
        echo ResponsiveServices::response(200, "Car added successfully");
        } else {
        echo ResponsiveServices::response(400, "There was a problem");
        }
    }



    function updateCar() {
    global $connection;  

    
    if (empty($_POST["id"])) {
        echo ResponseServices::response(500, "Enter ID please");
        return;
    }

    $id = $_POST["id"];
    $newName  = $_POST["new_name"]  ?? null;
    $newYear  = $_POST["new_year"]  ?? null;
    $newColor = $_POST["new_color"] ?? null;

    
    $car = Car::find($connection, $id);

    if (!$car) {
        echo ResponseServices::response(404, "Car not found");
        return;
    }

    
    if ($newName)  $car->name  = $newName;
    if ($newYear)  $car->year  = $newYear;
    if ($newColor) $car->color = $newColor;

    
    if ($car->update($connection)) {
        echo ResponseServices::response(200, "Excellent");
    } else {
        echo ResponseServices::response(400, "Not updated");
    }
}
}
?>