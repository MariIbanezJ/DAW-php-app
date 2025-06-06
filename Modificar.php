<?php
/**
 * Formulario de edición de productos - Vista CRUD
 *
 * Muestra un formulario pre-llenado con los datos del producto seleccionado
 * para permitir su modificación. Valida el ID recibido y gestiona la conexión a BD.
 *
 * @file      Modificar.php
 */




// Conexión a la base de datos
require_once('Connexio.php');

// Cabecera común de la aplicación
require_once('Header.php');



/**
 * Formulario para modificar un producto existente
 *
 * Este archivo obtiene la información de un producto por su ID, la muestra en un formulario
 * para su modificación, y envía los datos actualizados a `Actualitzar.php`.
 *
 *  Dependencias:
 *  - Connexio: se encarga de la conexión con la base de datos
 *  - Header: genera la cabecera HTML
 *  - Footer: genera el pie de página HTML
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Carles Canals
 *
 * @uses Connexio Para conectar con la base de datos
 * @uses Header Para mostrar la cabecera
 * @uses Footer Para mostrar el pie de página
 * @see Connexio::obtenirConnexio()
 */
class Modificar {

    /**
     * Muestra el formulario de modificación con los datos actuales del producto
     *
     * @param int|null $id ID del producto a modificar
     * @return void
     * @see Connexio::obtenirConnexio()
     */
    public function mostrarFormulari($id) {
        // Verifica si el ID del producto es válido
        if (!isset($id) || !is_numeric($id)) {
            echo '<p>ID de producto no válido.</p>';
            return;
        }

        // Obtiene la conexión a la base de datos
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Consulta para obtener la información del producto
        $consulta = "SELECT id, nom, descripció, preu, categoria_id
                     FROM productes
                     WHERE id = " . $id;
        $resultado = $conexion->query($consulta);

        // Verifica si se encontró el producto
        if ($resultado && $resultado->num_rows > 0) {
            $producto = $resultado->fetch_assoc();

            // Imprime la estructura HTML del formulario de modificación
            echo '<!DOCTYPE html>
                  <html lang="es">
                  <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <title>Modificar producte</title>
                    <!-- Enlace a Bootstrap desde su repositorio remoto -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                  </head>
                  <body>
                    <div class="container mt-5" style="margin-bottom: 200px">
                        <h2>Modificar producte</h2>
                        <hr>
                        <form action="Actualitzar.php" method="POST">
                            <!-- Campos del formulario con la información actual del producto -->
                            <input type="hidden" name="id" value="' . $producto['id'] . '">

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nombre:</label>
                                <input type="text" name="nom" class="form-control" value="' . $producto['nom'] . '" required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcio" class="form-label">Descripción:</label>
                                <input type="text" name="descripcio" class="form-control" value="' . $producto['descripció'] . '" required>
                            </div>

                            <div class="mb-3">
                                <label for="preu" class="form-label">Precio:</label>
                                <input type="number" name="preu" class="form-control" value="' . $producto['preu'] . '" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría:</label>
                                <select name="categoria" class="form-select" required>
                                    <!-- Opciones del selector de categorías con la opción seleccionada según la información actual -->
                                    <option value="1" ' . ($producto['categoria_id'] == 1 ? 'selected' : '') . '>Electrónicos</option>
                                    <option value="2" ' . ($producto['categoria_id'] == 2 ? 'selected' : '') . '>Roba</option>
                                    <!-- Agrega más opciones según sea necesario -->
                                </select>
                            </div>

                            <!-- Agrega más campos según sea necesario -->

                            <hr>
                            <!-- Botones de guardar y cancelar -->
                            <input type="submit" value="Guardar" class="btn btn-primary">
                            <a href="Principal.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>';
            
            // Incluye el pie de página
            require_once('Footer.php');
        } else {
            echo '<p>No se encontró el producto.</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Obtiene el ID del producto de la variable GET
$idProducto = isset($_GET['id']) ? $_GET['id'] : null;

// Instanciar la clase y mostrar el formulario
/** @var Modificar $modificarProducto */
$modificarProducto = new Modificar();

// Muestra el formulario
/** @see Modificar::mostrarFormulari()*/
$modificarProducto->mostrarFormulari($idProducto);

?>
