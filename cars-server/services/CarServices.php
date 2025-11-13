<?php
require_once(__DIR__ . "/../models/Car.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/ResponseService.php");

class CarServices {
    public static function deleteByIdHelper($connection, $id) {
        global $connection;

        $car = Car::find($connection, $id);
        if ($car) {
            if (Car::deleteById($connection, $id)) {
                return ["num" => 200, "message" => "Deleted successfully"];
            } else {
                return ["num" => 500, "message" => "Cannot delete"];
            }
        } else {
            return ["num" => 600, "message" => "Car not found"];
        }
    }
    
}
?>
