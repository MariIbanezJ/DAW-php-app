<?php
require_once('Connexio.php');
require_once('Header.php');

// Mostrar mensajes de error/success
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">'.htmlspecialchars($_GET['error']).'</div>';
}
?>

    <div class="container mt-5">
        <h2>Afegir Nou Producte</h2>
        <form action="nou.php" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom*</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="mb-3">
                <label for="descripcio" class="form-label">Descripció</label>
                <textarea class="form-control" id="descripcio" name="descripcio" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="preu" class="form-label">Preu (€)*</label>
                <input type="number" class="form-control" id="preu" name="preu"
                       step="0.01" min="0.01" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria*</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="">Selecciona una categoria</option>
                    <?php
                    $conexion = (new Connexio())->obtenirConnexio();
                    $categories = $conexion->query("SELECT * FROM categories");
                    while ($categoria = $categories->fetch_assoc()) {
                        echo '<option value="'.$categoria['id'].'">'.$categoria['nom'].'</option>';
                    }
                    $conexion->close();
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="Principal.php" class="btn btn-secondary">Cancel·lar</a>
        </form>
    </div>

<?php
require_once('Footer.php');
?>