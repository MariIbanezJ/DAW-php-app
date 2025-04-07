<?php
/**
 * Procesamiento de altas de productos - Formulario CRUD
 *
 * Archivo que gestiona la inserción de nuevos productos en la base de datos
 * mediante formularios web con validación y protección contra SQL injection.
 *
 * @file      nou.php
 * /

require_once('Connexio.php');

/**
 * Script para insertar un nuevo producto en la base de datos
 *
 * Este archivo procesa los datos enviados desde el formulario de alta de productos.
 * Realiza validaciones, y si los datos son  correctos, inserta el nuevo producto en la tabla `productes`.
 * Utiliza sentencias preparadas para prevenir inyecciones SQL.
 *
 *   Dependencias:
 *   - Connexio: se encarga de la conexión con la base de datos
 *
 * @package DAWphpapp
 * @version 1.0
 * @since 1.0
 * @author Juan Marí Ibáñez
 *
 * @uses Connexio Para la conexión con la base de datos
 * @see Connexio::obtenirConnexio()
 */
class Inserir {

    /**
     * Inserta un nuevo producto en la base de datos
     *
     * Valida los datos de entrada, establece una conexión a la base de datos y
     * ejecuta una sentencia preparada para insertar el producto.
     *
     * @param string $nom Nombre del producto
     * @param string $descripcio Descripción del producto
     * @param float $preu Precio del producto
     * @param int $categoria_id ID de la categoría seleccionada
     *
     * @return void
     * @throws Exception Si los datos son inválidos o ocurre un error en la base de datos
     * @see Connexio::obtenirConnexio()
     */
    public function afegirProducte($nom, $descripcio, $preu, $categoria_id) {
        // Validación de campos
        if (empty($nom) || empty($preu) || empty($categoria_id)) {
            throw new Exception('Tots els camps obligatoris són requerits');
        }

        if (!is_numeric($preu) || $preu <= 0) {
            throw new Exception('El preu ha de ser un número positiu');
        }

        if (!is_numeric($categoria_id)) {
            throw new Exception('Categoria no vàlida');
        }

        $conexionObj = new Connexio();
        $conexion = $conexionObj->obtenirConnexio();

        // Sentencia preparada para seguridad
        $consulta = $conexion->prepare("INSERT INTO productes 
                                      (nom, descripció, preu, categoria_id) 
                                      VALUES (?, ?, ?, ?)");
        $consulta->bind_param("ssdi", $nom, $descripcio, $preu, $categoria_id);

        if ($consulta->execute()) {
            header('Location: Principal.php?success=Producte afegit correctament');
            exit();
        } else {
            throw new Exception('Error en afegir el producte: ' . $conexion->error);
        }

        $consulta->close();
        $conexion->close();
    }
}

// Procesamiento del formulario
try {
    // Obtener y validar datos
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $descripcio = isset($_POST['descripcio']) ? trim($_POST['descripcio']) : '';
    $preu = isset($_POST['preu']) ? (float)$_POST['preu'] : 0;
    $categoria_id = isset($_POST['categoria']) ? (int)$_POST['categoria'] : 0;

    $inserir = new Inserir();
    $inserir->afegirProducte($nom, $descripcio, $preu, $categoria_id);

} catch (Exception $e) {
    // Redirigir con mensaje de error
    header('Location: AfegirProducte.php?error=' . urlencode($e->getMessage()));
    exit();
}
?>
