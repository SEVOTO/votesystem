<?php
require_once __DIR__ .('../../Modelo/Usuario.php');
require_once __DIR__ .('../../Modelo/Rol.php');

class UsuarioController {
    // Método para obtener un usuario por su ID
    public function obtenerUsuario($id) {
        $usuario = Usuario::obtenerPorId($id);

        if ($usuario) {
            // El usuario fue encontrado
            return $usuario;
        } else {
            // El usuario no existe
            return null;
        }
    }

    public function obtenerTodosUsuarios() {
        $usuarios = array();
    
        // Lógica para obtener todos los usuarios desde el modelo
        $usuariosModelo = Usuario::obtenerTodos();
    
        // Iterar sobre los usuarios obtenidos del modelo y crear objetos Usuario
        foreach ($usuariosModelo as $usuarioModelo) {
            $usuario = new Usuario($usuarioModelo['id'], $usuarioModelo['nombre'], $usuarioModelo['apellido'], $usuarioModelo['usuario'], $usuarioModelo['annio'], $usuarioModelo['seccion'], $usuarioModelo['pass'], $usuarioModelo['foto'], $usuarioModelo['id_rol']);
            $usuarios[] = $usuario;
        }
    
        return $usuarios;
    }
    

    // Método para validar las credenciales de un usuario
    public function validarCredenciales($usuario, $pass) {
        $usuarioValidado = Usuario::validarCredenciales($usuario, $pass);

        if ($usuarioValidado) {
            // Las credenciales son válidas
            session_start();

            if (isset($_SESSION['usuario'])) {
                session_destroy();
                session_start();
            }

            $rol = Rol::obtenerPorId($usuarioValidado->getIdRol());

            $_SESSION['usuario'] = $usuarioValidado->getNombre();
            $_SESSION['rol'] = $rol;

            if ($rol->getDescripcion() == "administrador") {
                header("Location: Vista/admin/home.php");
            } elseif ($rol->getDescripcion() == "estudiante") {
                header("Location: Vista/home.php");
            }
        } else {
            echo '<script>alert("Los datos son incorrectos. Por favor, verifica tus credenciales.");</script>';
        }
    }

        // Método para obtener los datos del estudiante por su cédula
    public function obtenerEstudiantePorCedula($cedula) {
        $estudiante = Estudiante::obtenerPorCedula($cedula);

        if ($estudiante) {
            // El estudiante fue encontrado
            return $estudiante;
        } else {
            // El estudiante no existe
            return null;
        }
    }

    public function crearUsuarioConCredenciales($pass, $id_rol) {
        $nuevoUsuario = new Usuario( null, $pass, $id_rol);
        $resultado = $nuevoUsuario->crear();
    
        if ($resultado) {
            // El usuario fue creado exitosamente
            return $nuevoUsuario;
        } else {
            // Hubo un error al crear el usuario
            return null;
        }
    }
    


    // Método para crear un nuevo usuario
    public function crearUsuario($nombre, $apellido, $usuario, $annio, $seccion, $pass, $foto, $id_rol) {
        $nuevoUsuario = new Usuario(null, $nombre, $apellido, $usuario, $annio, $seccion, $pass, $foto, $id_rol);
        $resultado = $nuevoUsuario->crear();

        if ($resultado) {
            // El usuario fue creado exitosamente
            return $nuevoUsuario;
        } else {
            // Hubo un error al crear el usuario
            return null;
        }
    }

    // Método para actualizar los datos de un usuario
    public function actualizarUsuario($id, $nombre, $apellido, $usuario, $annio, $seccion, $pass, $foto, $id_rol) {
        $usuarioExistente = Usuario::obtenerPorId($id);

        if ($usuarioExistente) {
            $usuarioExistente->setNombre($nombre);
            $usuarioExistente->setApellido($apellido);
            $usuarioExistente->setUsuario($usuario);
            $usuarioExistente->setAnnio($annio);
            $usuarioExistente->setSeccion($seccion);
            $usuarioExistente->setPass($pass);
            $usuarioExistente->setFoto($foto);
            $usuarioExistente->setIdRol($id_rol);

            $resultado = $usuarioExistente->actualizar();

            if ($resultado) {
                // El usuario fue actualizado exitosamente
                return $usuarioExistente;
            } else {
                // Hubo un error al actualizar el usuario
                return null;
            }
        } else {
            // El usuario no existe
            return null;
        }
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        $usuarioExistente = Usuario::obtenerPorId($id);

        if ($usuarioExistente) {
            $resultado = $usuarioExistente->eliminar();

            if ($resultado) {
                // El usuario fue eliminado exitosamente
                return true;
            } else {
                // Hubo un error al eliminar el usuario
                return false;
            }
        } else {
            // El usuario no existe
            return false;
        }
    }
}
