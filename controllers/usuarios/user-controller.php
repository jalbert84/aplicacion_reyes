<?php
require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/models/db/conexion.php");

class UsuariosController{
    
    public function registroUsuarioController($datos){

        // Insertar los datos del usuario en la base de datos
        $conexion = Conexion::conectar();
        
        // Normalizar el nombre de la calle para usarlo como nombre de tabla
        $tabla = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $datos["calle"]));
    
        // Preparar la consulta para insertar los datos en la tabla correspondiente
        $stmt = $conexion->prepare("INSERT INTO $tabla (numero, nombre, regalos) VALUES (:numero, :nombre, :regalos)");
        $stmt->bindParam(":numero", $datos["numero"]);
        $stmt->bindParam(":nombre", $datos["nombre"]);
        $stmt->bindParam(":regalos", $datos["regalos"]);
       
        // Ejecutar la consulta
        $stmt->execute();
    
        $_SESSION['registro_exitoso'] = true;
    }
    


    public function verificarUsuarioController($nombre, $calle) {
        // Preparar la consulta para verificar si el usuario existe en la tabla correspondiente a la calle
        $tabla = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $calle));
        $query = "SELECT * FROM $tabla WHERE nombre = :nombre";
        $db = Conexion::conectar();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Devolver true si el usuario existe, false si no existe
        return ($usuario !== false);
    }
    

    public function bajaUsuarioController($nombre, $calle) {
        // Preparar la consulta para eliminar al usuario de la tabla correspondiente a la calle
        $tabla = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $calle));
        $query = "DELETE FROM $tabla WHERE nombre = :nombre";
        $db = Conexion::conectar();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $result = $stmt->execute();
    
        if ($result) {
            return true; // Usuario eliminado correctamente
        } else {
            return "Error al eliminar el usuario."; // Mensaje de error
        }
    }
    

public function obtenerCallesDisponiblesController() {
    // Preparar la consulta para obtener todas las calles disponibles
    $query = "SHOW TABLES";
    $db = Conexion::conectar();
    $stmt = $db->prepare($query);
    $stmt->execute();

    // Obtener todas las tablas de la base de datos
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Filtrar las tablas que son calles
    $calles = [];
    foreach ($tablas as $tabla) {
        if ($tabla !== "usuarios") {
            $calles[] = $tabla;
        }
    }

    // Devolver las calles encontradas
    return $calles;
}
    
public function buscarUsuarioController($nombre) {
    // Preparar la consulta para buscar usuarios por nombre
    $query = "SELECT * FROM usuarios WHERE nombre LIKE :nombre";
    $db = Conexion::conectar();
    $stmt = $db->prepare($query);
    $nombreBusqueda = "%{$nombre}%"; // Añadir comodines para buscar coincidencias parciales
    $stmt->bindParam(':nombre', $nombreBusqueda);
    $stmt->execute();

    // Obtener los resultados de la búsqueda
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados
    return $usuarios;
}

public function modificarUsuarioController($usuario, $calle, $nuevoNombre, $nuevoNumero, $nuevosRegalos) {
    // Verificar que los datos recibidos sean válidos
    if ($usuario !== "" && $calle !== ""&& $nuevoNombre !== "" && $nuevoNumero !== "" && $nuevosRegalos !== "") {
        // Normalizar el nombre de la calle para usarlo como nombre de tabla
        $tabla = strtolower(str_replace(" ", "_", $calle));
        
        // Realizar la modificación en la base de datos
        $query = "UPDATE $tabla SET nombre = :nuevoNombre, numero = :nuevoNumero, regalos = :nuevosRegalos WHERE nombre = :usuario";
        $db = Conexion::conectar();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nuevoNombre', $nuevoNombre);
        $stmt->bindParam(':nuevoNumero', $nuevoNumero);
        $stmt->bindParam(':nuevosRegalos', $nuevosRegalos);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        echo "Usuario modificado correctamente.";
    } else {
        echo "No se recibieron todos los datos necesarios para modificar al usuario.";
    }
}


    
public function obtenerUsuariosPorCalleController($calle) {
    try {
        // Normalizar el nombre de la calle para usarlo como nombre de tabla
        $tabla = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $calle));

        // Preparar la consulta para obtener los usuarios de la calle correspondiente
        $query = "SELECT * FROM $tabla";
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare($query);
        $stmt->execute();

        // Obtener los resultados de la consulta
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    } catch (PDOException $e) {
        // En caso de error, lanzar una excepción
        throw new PDOException("Error al ejecutar la consulta: " . $e->getMessage());
    }
}

public function actualizarOrdenUsuariosController($usuariosOrdenados, $nombreTabla) {
    try {
        // Obtener la conexión a la base de datos
        $conexion = Conexion::conectar();

        // Comenzar una transacción
        $conexion->beginTransaction();

        // Obtener todos los usuarios de la tabla valencia y almacenarlos en un array
        $querySelect = "SELECT * FROM $nombreTabla";
        $stmtSelect = $conexion->prepare($querySelect);
        $stmtSelect->execute();
        $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

        // Borrar todos los usuarios de la tabla
        $queryDelete = "DELETE FROM $nombreTabla";
        $stmtDelete = $conexion->prepare($queryDelete);
        $stmtDelete->execute();

        // Insertar los usuarios en el nuevo orden, utilizando el orden especificado por $usuariosOrdenados
        foreach ($usuariosOrdenados as $idUsuario) {
            foreach ($usuarios as $usuario) {
                if ($usuario['id'] == $idUsuario) {
                    $queryInsert = "INSERT INTO $nombreTabla (numero, nombre, regalos) VALUES (:numero, :nombre, :regalos)";
                    $stmtInsert = $conexion->prepare($queryInsert);
                    $stmtInsert->bindValue(':numero', $usuario['numero']);
                    $stmtInsert->bindValue(':nombre', $usuario['nombre']);
                    $stmtInsert->bindValue(':regalos', $usuario['regalos']);
                    $stmtInsert->execute();
                    break;
                }
            }
        }

        // Confirmar la transacción
        $conexion->commit();

        // Devolver un mensaje de éxito
        return "El orden de los usuarios ha sido actualizado correctamente.";
    } catch (PDOException $e) {
        $conexion->rollBack();
        throw new Exception("Error al actualizar el orden de los usuarios: " . $e->getMessage());
    } catch (Exception $e) {
        throw new Exception("Error al actualizar el orden de los usuarios: " . $e->getMessage());
    }
}


    }

