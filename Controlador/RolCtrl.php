<?php
require_once __DIR__ .("../../Modelo/Rol.php");

class RolController {
    // Método para obtener un rol por su ID
    public function obtenerRol($id) {
        $rol = Rol::obtenerPorId($id);
        return $rol;
    }

    public function obtenerTodosRoles() {
        $roles = array();
    
        // Lógica para obtener todos los roles desde el modelo
        $rolModelo = Rol::obtenerTodos();
    
        // Iterar sobre los roles obtenidos del modelo y crear objetos Rol
        foreach ($rolModelo as $rolModelo) {
            $rol = new Rol($rolModelo['id'], $rolModelo['descripcion']);
            $roles[] = $rol;
        }
    
        return $roles;
    }
    
    



    // Método para crear un nuevo rol
    public function crearRol($descripcion) {
        $nuevoRol = new Rol(null, $descripcion);
        $resultado = $nuevoRol->crear();
        return $resultado;
    }

    // Método para actualizar un rol existente
    public function actualizarRol($id, $descripcion) {
        $rolExistente = Rol::obtenerPorId($id);

        if ($rolExistente) {
            $rolExistente->setDescripcion($descripcion);
            $resultado = $rolExistente->actualizar();
            return $resultado;
        } else {
            return false;
        }
    }

    // Método para eliminar un rol existente
    public function eliminarRol($id) {
        $rolExistente = Rol::obtenerPorId($id);

        if ($rolExistente) {
            $resultado = $rolExistente->eliminar();
            return $resultado;
        } else {
            return false;
        }
    }
}
?>
