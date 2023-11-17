<?php
class DBConexion
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "votesystem";

    public function getConexion()
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($conn->connect_error)
        {
            die("Error de conexion: " . $conn->connect_error);
        }
        return $conn;
    }

}