<?php
require_once('Connexio.php');
// Clase Eliminar cambio desde develop
class Eliminar {

    public function eliminarProducte($id) {
        // Validación del ID
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception('ID de producte no vàlid');
        }

        $connexioObj = new Connexio();
        $connexion = $connexioObj->obtenirConnexio();

        // Sentencia preparada para seguridad
        $consulta = $connexion->prepare("DELETE FROM productes WHERE id = ?");
        $consulta->bind_param("i", $id);

        if ($consulta->execute()) {
            // Verificar si realmente se eliminó algún registro
            if ($consulta->affected_rows > 0) {
                header('Location: Principal.php?success=Producte eliminat correctament');
            } else {
                header('Location: Principal.php?error=No s\'ha trobat el producte amb aquest ID');
            }
            exit();
        } else {
            throw new Exception('Error en eliminar el producte: ' . $connexion->error);
        }

        $consulta->close();
        $connexion->close();
    }
}

// Procesamiento de la solicitud
try {
    // Solo permitir método GET con parámetro ID
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        // Opcional: añadir confirmación por parámetro
        if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
            $eliminar = new Eliminar();
            $eliminar->eliminarProducte($id);
        } else {
            // Redirigir a confirmación si no hay parámetro de confirmación
            header('Location: confirmar_eliminacio.php?id=' . $id);
            exit();
        }
    } else {
        throw new Exception('Solicitud no vàlida');
    }
} catch (Exception $e) {
    header('Location: Principal.php?error=' . urlencode($e->getMessage()));
    exit();
}
