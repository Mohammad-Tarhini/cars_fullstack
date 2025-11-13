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
    $allData = [];

    while ($row = $result->fetch_assoc()) {
        $allData[] = $row;
    }

    if (empty($Data)) {
        return null; // return null if no rows
    }

    $Objects = [];
    foreach ($allData as $Data) {
        $Objects[] = new static($Data);
    }
    return $Objects;
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
        $query->bind_param("i",$this->getID());
        return $query->execute();

    }


   


public function insert(mysqli $connection)
{
    $data = $this->toArray();

    $keys = array_keys($data);
    $placeHolders = implode(',', array_fill(0, count($keys), '?'));
    
    $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, implode(',', $keys), $placeHolders);

    $query = $connection->prepare($sql);

    
    $types = '';
    $values = [];
    foreach ($data as $value) {
        if (is_int($value)) $types .= 'i';
        elseif (is_float($value)) $types .= 'd';
        else $types .= 's';
        $values[] = $value;
    }

    $query->bind_param($types, ...$values);
    return $query->execute();
}

 public function update(mysqli $connection ){

    $data = $this->toArray();

    $setParts = [];
    $values = [];
    $types = '';

    foreach ($data as $key => $value) {
        if (isset($value) && $key !== static::$primary_key) {
            $setParts[] = "$key = ?";
            $values[] = $value;

            
            if (is_int($value)) $types .= 'i';
            elseif (is_float($value)) $types .= 'd';
            else $types .= 's';
        }
    }

    $sql = sprintf(
        "UPDATE %s SET %s WHERE %s = ?",
        static::$table,
        implode(', ', $setParts),
        static::$primary_key
    );

    $query = $connection->prepare($sql);

    
    $values[] = $this->getID();
    $types .= 'i';

    $query->bind_param($types, ...$values);

    return $query->execute();


 }}
?>
