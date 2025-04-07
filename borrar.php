<?php

/**
 * Controlador de eliminación de productos - Operación CRUD
 *
 * Gestiona la eliminación segura de productos mediante validación estricta
 * y uso de sentencias preparadas para prevenir inyecciones SQL.
 *
 * @file      borrar.php
 */

// Conexión a la base de datos
require_once('Connexio.php');

/**
 * Script para eliminar un producto de la base de datos
 *
 * Este archivo valida una solicitud GET con el ID del producto, verifica la confirmación
 * del usuario y ejecuta la eliminación mediante una sentencia preparada.
 *
 *  Dependencias:
 *  - Connexio: se encarga de la conexión con la base de datos
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Juan Marí Ibáñez
 *
 * @uses Connexio Para la conexión a la base de datos
 * @see Connexio::obtenirConnexio()
 */
class Eliminar {

    /**
     * Elimina un producto por su ID
     *
     * Valida el ID, establece una conexión a la base de datos y ejecuta
     * una sentencia preparada para eliminar el producto.
     *
     * @param int $id ID del producto a eliminar
     * @return void
     * @throws Exception Si el ID no es válido o hay un error en la consulta
     * @see Connexio::obtenirConnexio()
     */
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
    // Solo permitir métod o GET con parámetro ID
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

    // Redirige a la página principal con el mensaje de error
    header('Location: Principal.php?error=' . urlencode($e->getMessage()));
    exit();
}
