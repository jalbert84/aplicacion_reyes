<?php
require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/models/db/conexion.php");

class UsuariosController {
    
    public function registroUsuarioController($datos) {
        $conexion = Conexion::conectar();
        
        // Normalizar el nombre de la calle para usarlo como nombre de tabla
        $tabla = strtolower(preg_replace("/[^A-Za-z0-9]/", "", $datos["calle"]));
        
        // Verificar si el nombre ya existe en la tabla
        $stmtCheck = $conexion->prepare("SELECT COUNT(*) FROM $tabla WHERE nombre = :nombre");
        $stmtCheck->bindParam(":nombre", $datos["nombre"]);
        $stmtCheck->execute();
        $nombreExistente = $stmtCheck->fetchColumn();

        if ($nombreExistente > 0) {
            // Nombre duplicado, mostrar mensaje y salir
            echo '<script>alert("¡Error! El nombre ya está registrado en esa calle.");</script>';
            return; // Terminar la función para que no se registre
        }

        // Obtener el número de usuarios actuales en la tabla para determinar el próximo id
        $stmtCount = $conexion->prepare("SELECT COUNT(*) FROM $tabla");
        $stmtCount->execute();
        $nextId = $stmtCount->fetchColumn() + 1;

        // Preparar la consulta para insertar los datos en la tabla correspondiente
        $stmt = $conexion->prepare("INSERT INTO $tabla (id, numero, nombre, regalos) VALUES (:id, :numero, :nombre, :regalos)");
        $stmt->bindParam(":id", $nextId);
        $stmt->bindParam(":numero", $datos["numero"]);
        $stmt->bindParam(":nombre", $datos["nombre"]);
        $stmt->bindParam(":regalos", $datos["regalos"]);
        
        $stmt->execute();

        $_SESSION['registro_exitoso'] = true;

        echo '<script>alert("¡Usuario registrado correctamente!");</script>';
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

public function editarUsuarioDesdeVista($id, $nuevoNumero, $nuevoNombre, $nuevosRegalos) {
    try {
        if ($id !== "" && $nuevoNombre !== "" && $nuevoNumero !== "" && $nuevosRegalos !== "") {
            // Buscar en qué tabla está el usuario
            $db = Conexion::conectar();
            $calles = [
    '8demarzo',
    'antonioespolio',
    'assegadors',
    'ausiasmarch',
    'blascoibanyez',
    'bonifaciferrer',
    'calvari',
    'camiderafelbunyol',
    'cavallers3849final',
    'cavallers13647',
    'doctornavarro',
    'donemilioramonllin',
    'donpedrotortajada',
    'joaquinsorolla',
    'lanoria',
    'lasequia',
    'major',
    'mestrepalau',
    'mestreserrano',
    'plazaanticregnedevalencia',
    'plazalacreu',
    'plazanoudoctubre',
    'plazasantjoanderibera',
    'poetaricardovalero',
    'primerdemaig18',
    'primerdemaig19final',
    'puntarro',
    'rajolars',
    'ramonicajal',
    'realacequiademoncada',
    'santabarbera',
    'santbertomeu',
    'santdidac',
    'santvicent',
    'tarazona',
    'tirantloblanc',
    'valencia',
    'vicentlassala'
];


            foreach ($calles as $calle) {
                $query = "SELECT id FROM $calle WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // Si existe, actualiza
                    $update = "UPDATE $calle SET numero = :numero, nombre = :nombre, regalos = :regalos WHERE id = :id";
                    $updateStmt = $db->prepare($update);
                    $updateStmt->bindParam(':numero', $nuevoNumero);
                    $updateStmt->bindParam(':nombre', $nuevoNombre);
                    $updateStmt->bindParam(':regalos', $nuevosRegalos);
                    $updateStmt->bindParam(':id', $id);
                    $updateStmt->execute();
                    return true;
                }
            }

            return false; // No encontrado en ninguna tabla
        } else {
            return false;
        }
    } catch (PDOException $e) {
        throw new Exception("Error al modificar al usuario: " . $e->getMessage());
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

        // Obtener todos los usuarios de la tabla y almacenarlos en un array
        $querySelect = "SELECT * FROM $nombreTabla";
        $stmtSelect = $conexion->prepare($querySelect);
        $stmtSelect->execute();
        $usuarios = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

        // Borrar todos los usuarios de la tabla
        $queryDelete = "DELETE FROM $nombreTabla";
        $stmtDelete = $conexion->prepare($queryDelete);
        $stmtDelete->execute();

        // Insertar los usuarios en el nuevo orden, utilizando el orden especificado por $usuariosOrdenados
        $nuevoId = 1;
        foreach ($usuariosOrdenados as $idUsuario) {
            foreach ($usuarios as $usuario) {
                if ($usuario['id'] == $idUsuario) {
                    $queryInsert = "INSERT INTO $nombreTabla (id, numero, nombre, regalos) VALUES (:id, :numero, :nombre, :regalos)";
                    $stmtInsert = $conexion->prepare($queryInsert);
                    $stmtInsert->bindValue(':id', $nuevoId);
                    $stmtInsert->bindValue(':numero', $usuario['numero']);
                    $stmtInsert->bindValue(':nombre', $usuario['nombre']);
                    $stmtInsert->bindValue(':regalos', $usuario['regalos']);
                    $stmtInsert->execute();
                    $nuevoId++;
                    break;
                }
            }
        }
        $query = "SELECT * FROM $nombreTabla ORDER BY numero ASC"; // Para ordenar por el número de usuario

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

