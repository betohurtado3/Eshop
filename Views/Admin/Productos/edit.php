<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM Productos WHERE Id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

require "../../Layouts/header.php";
require "../../Layouts/navbar.php";
?>

<div class="container py-5">

    <div class="card shadow p-4 mx-auto" style="max-width:600px;">
        <h3 class="mb-4 text-center">Editar Producto</h3>

        <form action="update.php" method="POST">
            <input type="hidden" name="Id" value="<?= $p['Id']; ?>">

            <input class="form-control mb-3" name="Nombre" value="<?= $p['Nombre']; ?>">
            <input class="form-control mb-3" name="Slug" value="<?= $p['Slug']; ?>">
            <input class="form-control mb-3" name="Coleccion" value="<?= $p['Coleccion']; ?>">

            <textarea class="form-control mb-3" name="DescripcionCorta"><?= $p['DescripcionCorta']; ?></textarea>
            <textarea class="form-control mb-3" name="DescripcionLarga"><?= $p['DescripcionLarga']; ?></textarea>

            <input class="form-control mb-3" name="Precio" value="<?= $p['Precio']; ?>">
            <input class="form-control mb-3" name="Stock" value="<?= $p['Stock']; ?>">

            <select class="form-select mb-4" name="Estado">
                <option value="1" <?= $p['Estado'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?= $p['Estado'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <button class="btn btn-primary w-100">Actualizar Producto</button>
        </form>
    </div>

</div>

<?php require "../../Layouts/footer.php"; ?>
