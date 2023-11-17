<?php
require_once __DIR__ . '/../Modelo/Estudiante.php';

class EstudianteController {
    public function obtenerEstudiante($id) {
        $estudiante = Estudiante::obtenerPorId($id);

        if ($estudiante) {
            return $estudiante;
        } else {
            return null;
        }
    }

    public function obtenerTodosEstudiantes() {
        $estudiantes = array();

        $estudiantesModelo = Estudiante::obtenerTodos();

        foreach ($estudiantesModelo as $estudianteModelo) {
            $estudiante = new Estudiante($estudianteModelo['id'], $estudianteModelo['nombre'], $estudianteModelo['apellido'], $estudianteModelo['cedula'], $estudianteModelo['liceo'], $estudianteModelo['annio'], $estudianteModelo['seccion'], $estudianteModelo['foto']);
            $estudiantes[] = $estudiante;
        }

        return $estudiantes;
    }

    public function crearEstudiante($nombre, $apellido, $cedula, $liceo, $annio, $seccion, $foto) {
        $nuevoEstudiante = new Estudiante(null, $nombre, $apellido, $cedula, $liceo, $annio, $seccion, $foto);
        $resultado = $nuevoEstudiante->crear();

        if ($resultado) {
            return $nuevoEstudiante;
        } else {
            return null;
        }
    }

    public function actualizarEstudiante($id, $nombre, $apellido, $cedula, $liceo, $annio, $seccion, $foto) {
        $estudianteExistente = Estudiante::obtenerPorId($id);

        if ($estudianteExistente) {
            $estudianteExistente->setNombre($nombre);
            $estudianteExistente->setApellido($apellido);
            $estudianteExistente->setCedula($cedula);
            $estudianteExistente->setLiceo($liceo);
            $estudianteExistente->setAnnio($annio);
            $estudianteExistente->setSeccion($seccion);
            $estudianteExistente->setFoto($foto);

            $resultado = $estudianteExistente->actualizar();

            if ($resultado) {
                return $estudianteExistente;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function eliminarEstudiante($id) {
        $estudianteExistente = Estudiante::obtenerPorId($id);

        if ($estudianteExistente) {
            $resultado = $estudianteExistente->eliminar();

            if ($resultado) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
