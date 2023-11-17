<?php
require_once("conexion.php");

class Rol {
    private $id;
    private $descripcion;

    public function __construct($id, $descripcion) {
        $this->id = $id;
        $this->descripcion = $descripcion;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public static function obtenerPorId($id) {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $query = "SELECT * FROM rol WHERE id = $id";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $rol = new Rol($row['id'], $row['descripcion']);
            return $rol;
        } else {
            return null;
        }
    }

    public static function obtenerTodos() {
        $db = new DBConexion();
        $conn = $db->getConexion();
    
        $query = "SELECT * FROM rol";
        $result = $conn->query($query);
    
        $rol = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rol[] = $row;
            }
        }
    
        return $rol;
    }

    public function crear() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $descripcion = $conn->real_escape_string($this->descripcion);

        $query = "INSERT INTO rol (descripcion) VALUES ('$descripcion')";
        $result = $conn->query($query);

        if ($result) {
            $this->id = $conn->insert_id;
            return true;
        } else {
            return false;
        }
    }

    public function actualizar() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $id = $conn->real_escape_string($this->id);
        $descripcion = $conn->real_escape_string($this->descripcion);

        $query = "UPDATE rol SET descripcion = '$descripcion' WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }

    public function eliminar() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $id = $conn->real_escape_string($this->id);

        $query = "DELETE FROM rol WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }
}
?>
