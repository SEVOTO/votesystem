<?php
require_once("conexion.php");
require_once("Estudiante.php");

class Usuario extends Estudiante{
        // Propiedades de la clase Usuario
    private $id;
    private $usuario;
    private $pass;
    private $id_rol;

    // Constructor de la clase Usuario
    public function __construct($id, $usuario, $pass, $id_rol) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->id_rol = $id_rol;
    }

    // Métodos de acceso (getters) y modificación (setters) para las propiedades
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getIdRol() {
        return $this->id_rol;
    }

    public function setIdRol($id_rol) {
        $this->id_rol = $id_rol;
    }

    // Método para obtener un usuario por su ID
    public static function obtenerPorId($id) {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $query = "SELECT * FROM usuarios WHERE id = $id";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $usuario = new Usuario($row['id'], $row['usuario'], $row['pass'], $row['id_rol']);
            return $usuario;
        } else {
            return null;
        }
    }

    public static function obtenerTodos() {
        $db = new DBConexion();
        $conn = $db->getConexion();
    
        $query = "SELECT * FROM usuarios";
        $result = $conn->query($query);
    
        $usuarios = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
    
        return $usuarios;
    }
    

    // Método para validar las credenciales de un usuario
    public static function validarCredenciales($usuario, $pass) {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $usuario = $conn->real_escape_string($usuario);
        $pass = $conn->real_escape_string($pass);

        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND pass = '$pass'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $estudiante = Estudiante::obtenerPorCedula($row['cedula']);

            if ($estudiante) {
                $usuario = new Usuario($estudiante->getId(), $estudiante->getNombre(), $estudiante->getApellido(), $estudiante->getCedula(), $estudiante->getLiceo(), $estudiante->getAnnio(), $estudiante->getSeccion(), $estudiante->getFoto(), $row['usuario'], $row['contrasena'], $row['id_rol']);
                return $usuario;
            }
        }

        return null;
    }


    // Método para crear un nuevo usuario
    public function crear() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $usuario = $conn->real_escape_string($this->usuario);
        $pass = $conn->real_escape_string($this->pass);
        $id_rol = $conn->real_escape_string($this->id_rol);

        $query = "INSERT INTO usuarios (usuario, pass, id_rol) VALUES ('$usuario', '$pass', '$id_rol')";
        $result = $conn->query($query);

        if ($result) {
            $this->id = $conn->insert_id;
            return true;
        } else {
            return false;
        }
    }

    // Método para actualizar los datos de un usuario
    public function actualizar() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $id = $conn->real_escape_string($this->id);
        $usuario = $conn->real_escape_string($this->usuario);
        $pass = $conn->real_escape_string($this->pass);
        $id_rol = $conn->real_escape_string($this->id_rol);

        $query = "UPDATE usuarios SET  usuario = '$usuario', pass = '$pass', id_rol = '$id_rol' WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }

    // Método para eliminar un usuario
    public function eliminar() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $id = $conn->real_escape_string($this->id);

        $query = "DELETE FROM usuarios WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }
}
?>
