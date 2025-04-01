<?php
require_once('Connexio.php');
require_once('Header.php');

// Verificar que se haya proporcionado un ID válido
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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
require_once('Footer.php');
?>