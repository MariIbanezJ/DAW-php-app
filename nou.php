<?php
require_once('Connexio.php');

class Inserir {

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
