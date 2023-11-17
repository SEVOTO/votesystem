<?php
require_once("conexion.php");

class Estudiante {
    private $id;
    private $nombre;
    private $apellido;
    private $cedula;
    private $liceo;
    private $annio;
    private $seccion;
    private $foto;

    public function __construct($id, $nombre, $apellido, $cedula, $liceo, $annio, $seccion, $foto) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cedula = $cedula;
        $this->liceo = $liceo;
        $this->annio = $annio;
        $this->seccion = $seccion;
        $this->foto = $foto;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getLiceo() {
        return $this->liceo;
    }

    public function setLiceo($liceo) {
        $this->liceo = $liceo;
    }

    public function getAnnio() {
        return $this->annio;
    }

    public function setAnnio($annio) {
        $this->annio = $annio;
    }

    public function getSeccion() {
        return $this->seccion;
    }

    public function setSeccion($seccion) {
        $this->seccion = $seccion;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public static function obtenerPorId($id) {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $query = "SELECT * FROM estudiante WHERE id = $id";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $estudiante = new Estudiante($row['id'], $row['nombre'], $row['apellido'], $row['cedula'], $row['liceo'], $row['annio'], $row['seccion'], $row['foto']);
            return $estudiante;
        } else {
            return null;
        }
    }

    public static function obtenerTodos() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $query = "SELECT * FROM estudiante";
        $result = $conn->query($query);

        $estudiantes = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = $row;
            }
        }

        return $estudiantes;
    }
    

    public static function obtenerPorCedula($cedula) {
        $db = new DBConexion();
        $conn = $db->getConexion();
    
        $query = "SELECT * FROM estudiante WHERE cedula = '$cedula'";
        $result = $conn->query($query);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $estudiante = new Estudiante($row['id'], $row['nombre'], $row['apellido'], $row['cedula'], $row['liceo'], $row['annio'], $row['seccion'], $row['foto']);
            return $estudiante;
        } else {
            return null;
        }
    }
    

    public function crear() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $nombre = $conn->real_escape_string($this->nombre);
        $apellido = $conn->real_escape_string($this->apellido);
        $cedula = $conn->real_escape_string($this->cedula);
        $liceo = $conn->real_escape_string($this->liceo);
        $annio = $conn->real_escape_string($this->annio);
        $seccion = $conn->real_escape_string($this->seccion);
        $foto = $conn->real_escape_string($this->foto);

        $query = "INSERT INTO estudiante (nombre, apellido, cedula, liceo, annio, seccion, foto) VALUES ('$nombre', '$apellido', '$cedula', '$liceo', '$annio', '$seccion', '$foto')";
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
        $nombre = $conn->real_escape_string($this->nombre);
        $apellido = $conn->real_escape_string($this->apellido);
        $cedula = $conn->real_escape_string($this->cedula);
        $liceo = $conn->real_escape_string($this->liceo);
        $annio = $conn->real_escape_string($this->annio);
        $seccion = $conn->real_escape_string($this->seccion);
        $foto = $conn->real_escape_string($this->foto);

        $query = "UPDATE estudiante SET nombre = '$nombre', apellido = '$apellido', cedula = '$cedula', liceo = '$liceo', annio = '$annio', seccion = '$seccion', foto = '$foto' WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }

    public function eliminar() {
        $db = new DBConexion();
        $conn = $db->getConexion();

        $id = $conn->real_escape_string($this->id);

        $query = "DELETE FROM estudiante WHERE id = $id";
        $result = $conn->query($query);

        return $result;
    }
}
?>
