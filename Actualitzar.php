<?php
/**
 * Controlador de actualización de productos - Operación CRUD
 *
 * Gestiona la actualización segura de productos mediante validación de datos
 * y uso de sentencias preparadas para prevenir inyecciones SQL.
 *
 * @file      Actualitzar.php
 */


// Incluye el archivo de conexión
require_once('Connexio.php');


/**
 * Clase encargada de actualizar un producto en la base de datos
 *
 * Procesa los datos enviados por POST desde un formulario de edición de producto.
 * Valida los datos, los limpia para prevenir inyecciones SQL, y actualiza el producto correspondiente
 * en la base de datos utilizando la clase `Connexio`.
 *
 *  Dependencias:
 *  - Connexio: se encarga de la conexión con la base de datos
 *
 * @package DAWphpapp
 * @version 1.0
 * @author Carles Canals
 * @since 1.0
 *
 * @uses Connexio Para obtener y cerrar la conexión a la base de datos
 * @see Connexio
 */
class Actualitzar {

    /**
     * Actualiza un producto en la base de datos.
     *
     * Esta función valida que todos los campos requeridos estén presentes, escapa los datos
     * para evitar inyecciones SQL, ejecuta la consulta de actualización y redirige al usuario
     * a la página principal si tiene éxito.
     *
     * @param string $id ID del producto que se va a actualizar.
     * @param string $nom Nombre del producto.
     * @param string $descripcio Descripción del producto.
     * @param string $preu Precio del producto.
     * @param string $categoria ID de la categoría del producto.
     *
     * @return void
     * @throws mysqli_sql_exception Si ocurre un error durante la consulta SQL.
     * @see Connexio::obtenirConnexio()
     */
    public function actualizar($id, $nom, $descripcio, $preu, $categoria) {
        // Verifica si todos los campos requeridos están presentes
        if (!isset($id) || !isset($nom) || !isset($descripcio) || !isset($preu) || !isset($categoria)) {
            echo '<p>Se requieren todos los campos para actualizar el producto.</p>';
            return;
        }

        // Crea una instancia de la clase de conexión
        $conexionObj = new Connexio();
        // Obtiene la conexión a la base de datos
        $conexion = $conexionObj->obtenirConnexio();

        // Escapa las variables para prevenir SQL injection
        $id = $conexion->real_escape_string($id);
        $nom = $conexion->real_escape_string($nom);
        $descripcio = $conexion->real_escape_string($descripcio);
        $preu = $conexion->real_escape_string($preu);
        $categoria = $conexion->real_escape_string($categoria);

        // Construye la consulta SQL de actualización
        $consulta = "UPDATE productes
                     SET nom = '$nom', descripció = '$descripcio', preu = '$preu', categoria_id = '$categoria'
                     WHERE id = '$id'";

        // Ejecuta la consulta y redirige a la página principal si tiene éxito
        if ($conexion->query($consulta) === TRUE) {
            header('Location: Principal.php');
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al actualizar el producto: ' . $conexion->error . '</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Obtiene los valores del formulario (si existen)
$id = isset($_POST['id']) ? $_POST['id'] : null;
$nom = isset($_POST['nom']) ? $_POST['nom'] : null;
$descripcio = isset($_POST['descripcio']) ? $_POST['descripcio'] : null;
$preu = isset($_POST['preu']) ? $_POST['preu'] : null;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

// Ejecuta el proceso de actualización
/** @var Actualitzar $actualizarProducto */
$actualizarProducto = new Actualitzar();

// Llama a la función que actualiza el producto con los datos recibidos
/** @see Actualitzar::actualizar()*/
$actualizarProducto->actualizar($id, $nom, $descripcio, $preu, $categoria);

?>
