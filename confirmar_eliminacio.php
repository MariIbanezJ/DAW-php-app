<?php

/**
 * Confirmación de eliminación de productos - Vista CRUD
 *
 * Muestra diálogo de confirmación antes de eliminar un producto,
 * validando el ID y mostrando información del producto a eliminar.
 *
 * @file      confirmar_eliminacio.php
 */


/**
 * Confirmación de eliminación de producto
 *
 * Este archivo muestra una página de confirmación antes de eliminar definitivamente
 * un producto de la base de datos. Recupera el nombre del producto por su ID y muestra
 * al usuario una advertencia con opciones para cancelar o proceder.
 *
 *  Dependencias:
 *  - Connexio: se encarga de la conexión con la base de datos
 *  - Header: genera la cabecera HTML
 *  - Footer: genera el pie de página HTML
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Juan Marí Ibáñez
 *
 * @uses Connexio Para obtener la información del producto
 * @uses Header Para mostrar la cabecera de la aplicación
 * @uses Footer Para mostrar el pie de página de la aplicación
 * @see Connexio::obtenirConnexio()
 */


// Conexión a la base de datos
require_once('Connexio.php');

// Cabecera común de la aplicación
require_once('Header.php');

// Verificar que se haya proporcionado un ID válido
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Redirigir si el ID no es válido
if ($id <= 0) {
    header('Location: Principal.php?error=ID de producte no vàlid');
    exit();
}

// Obtener información del producto para mostrar en la confirmación
$connexio = (new Connexio())->obtenirConnexio();
$stmt = $connexio->prepare("SELECT nom FROM productes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producte = $result->fetch_assoc();
$stmt->close();
$connexio->close();

// Redirigir si el producto no existe
if (!$producte) {
    header('Location: Principal.php?error=Producte no trobat');
    exit();
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h4>Confirmar Eliminació</h4>
        </div>
        <div class="card-body">
            <p>Estàs segur que vols eliminar el producte: <strong><?= htmlspecialchars($producte['nom']) ?></strong>?</p>
            <p>Aquesta acció no es pot desfer.</p>

            <div class="d-flex justify-content-between mt-4">
                <a href="Principal.php" class="btn btn-secondary">Cancel·lar</a>
                <a href="borrar.php?id=<?= $id ?>&confirm=true" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Eliminar Definitivament
                </a>
            </div>
        </div>
    </div>
</div>

<?php
// Pie de página común de la aplicación
require_once('Footer.php');
?>