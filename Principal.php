<?php
/**
 * Vista principal de gestión de productos - Muestra listado CRUD en tabla HTML
 *
 * Archivo que carga las dependencias necesarias (conexión BD y cabecera) y define
 * la clase Principal para renderizar la interfaz de productos.
 *
 * @file      Principal.php
 */

// Conexión a la base de datos
require_once('Connexio.php');

// Cabecera HTML común
require_once('Header.php');

/**
 * Clase Principal que gestiona la visualización de productos
 *
 * Esta clase muestra una lista de productos junto con sus categorías,
 * y ofrece funcionalidades para añadir, modificar y eliminar productos.
 *
 * Dependencias:
 * - Connexio: se encarga de la conexión con la base de datos
 * - Header: genera la cabecera HTML
 * - Footer: genera el pie de página HTML
 *
 * @package DAWphpapp
 * @version 1.0
 * @author Carles Canals
 * @since 1.0
 * @uses Connexio gestiona la conexión con la base de datos
 * @uses Header muestra la cabecera de la aplicación
 * @uses Footer muestra el pie de página de la aplicación
 * @see Connexio::obtenirConnexio()
 * @see Header::mostrar()
 * @see Footer::mostrarFooter()
 */
class Principal {

    /**
     * Muestra la lista de productos en formato de tabla HTML
     *
     * Esta función obtiene los productos de la base de datos junto con su categoría,
     * y los muestra en una tabla con opciones para modificar y eliminar cada producto.
     * También incluye un botón para añadir nuevos productos.
     *
     * @return void
     * @see Connexio::obtenirConnexio() obtiene la conexión a la base de datos.
     */
    public function mostrarProductes() {
        // Obtiene la conexión a la base de datos
        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Consulta para obtener la lista de productos con información de categorías
        $consulta = "SELECT p.id, p.nom, p.descripció, p.preu, c.nom as categoria
                     FROM productes p
                     INNER JOIN categories c ON p.categoria_id = c.id";
        $resultado = $conexion->query($consulta);

        // Estructura HTML de la página
        echo '<!DOCTYPE html>
              <html lang="es">
              <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Llista de productes</title>
                <!-- Enlace a Bootstrap desde su repositorio remoto -->
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
              </head>
              <body>
                <div class="container mt-5" style="margin-bottom: 100px">';

        // Verifica si hay productos en la base de datos
        if ($resultado->num_rows > 0) {
            // Botón para agregar un nuevo producto
            echo '<hr><a href="nou.php" class="btn btn-primary">Nou producte</a><hr>';
            // Tabla para mostrar la lista de productos
            echo '<table class="table table-striped">';
            echo '<thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Descripció</th>
                        <th>Preu</th>
                        <th>Categoria</th>
                        <th colspan="2">Accions</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            $i = 1;
            // Itera sobre los resultados y muestra cada producto en una fila de la tabla
            while ($fila = $resultado->fetch_assoc()) {
                echo '<tr>
                        <td>' . $i . '</td>
                        <td>' . 'prod-' . $fila['id'] . '</td>
                        <td>' . $fila['nom'] . '</td>
                        <td>' . $fila['descripció'] . '</td>
                        <td>' . $fila['preu'] . '</td>
                        <td>' . $fila['categoria'] . '</td>
                        <td><a href="Modificar.php?id=' . $fila['id'] . '" class="btn btn-warning">Modificar</a></td>
                        <td><a href="confirmar_eliminacio.php?id=' . $fila['id'] . '" class="btn btn-danger">Eliminar</a></td>
                      </tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            // Incluye el pie de página
            require_once('Footer.php');
        } else {
            // Mensaje si no hay productos
            echo '<p>No hi ha productes.</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Crea una instancia de la clase Principal
/** @var Principal $listaProductos */
$listaProductos = new Principal();

// Ejecuta la función que muestra los productos
/**@see Principal::mostrarProductes()*/
$listaProductos->mostrarProductes();

?>
