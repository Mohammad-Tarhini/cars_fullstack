<?php
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, int $id){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function findAll(mysqli $connection) {
    $sql = sprintf("SELECT * FROM %s", static::$table);
    $query = $connection->prepare($sql);

    if (!$query->execute()) {
        return null; // early return if execution fails
    }

    $result = $query->get_result();
    $carsData = [];

    while ($row = $result->fetch_assoc()) {
        $carsData[] = $row;
    }

    if (empty($carsData)) {
        return null; // return null if no rows
    }

    $carsObjects = [];
    foreach ($carsData as $carData) {
        $carsObjects[] = new static($carData);
    }

    return $carsObjects;
    }


    public static function deleteById(mysqli $connection, int $id) {
    $sql = sprintf("delete from %s where %s=?",
                   static::$table,
                   static::$primary_key);
    $query = $connection->prepare($sql);
    $query->bind_param("i", $id);
    return $query->execute();
    }

    public function delete(mysqli $connection){
        $sql =sprintf("delete from %s where %s=?",static::$table,static::$primary_key);
        $query=$connection->prepare($sql);
        $query->bind_param("i",$this->id);
        return $query->execute();

    }


    public function update(mysqli $connection ){
        $sql=printf("update %s  where %s=?",static::$table,static::$primary_key);
        $query=$connection->prepare($sql);
        $query->bind_param("i",$id);
        return $query->execute();
    }
    public static insert(mysqli $connection ){
        $sql=printf("insert into %s values()",static::$table,static::$primary_key);
        $query=$connection->prepare($sql);
        $query
        }


    


    public static insert(mysqli $connection){
        $sql=sprintf("insert into % ()")
    }


}
?>
