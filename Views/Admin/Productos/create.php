<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

require "../../Layouts/header.php";
require "../../Layouts/navbar.php";
?>

<div class="container py-5">

    <div class="card shadow p-4 mx-auto" style="max-width:600px;">
        <h3 class="mb-4 text-center">Nuevo Producto</h3>

        <form action="store.php" method="POST">

            <input type="text" name="Nombre" class="form-control mb-3" placeholder="Nombre" required>
            <input type="text" name="Slug" class="form-control mb-3" placeholder="Slug" required>
            <input type="text" name="Coleccion" class="form-control mb-3" placeholder="Colección" required>

            <textarea name="DescripcionCorta" class="form-control mb-3" placeholder="Descripción corta"></textarea>
            <textarea name="DescripcionLarga" class="form-control mb-3" placeholder="Descripción larga"></textarea>

            <input type="number" step="0.01" name="Precio" class="form-control mb-3" placeholder="Precio" required>
            <input type="number" name="Stock" class="form-control mb-3" placeholder="Stock" required>

            <select name="Estado" class="form-select mb-4">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>

            <button class="btn btn-success w-100">Guardar Producto</button>
        </form>
    </div>

</div>

<?php require "../../Layouts/footer.php"; ?>
