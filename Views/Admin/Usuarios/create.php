<?php
require __DIR__ . "/../../../Config/admin_guard.php";
require __DIR__ . "/../../Layouts/header.php";
require __DIR__ . "/../../Layouts/navbar.php";
?>

<div class="container py-5" style="max-width: 600px;">

    <h2 class="fw-bold mb-4">Nuevo Usuario</h2>

    <form action="store.php" method="POST">

        <input type="text" name="Nombre" class="form-control mb-3" placeholder="Nombre completo" required>

        <input type="text" name="Usuario" class="form-control mb-3" placeholder="Usuario" required>

        <input type="email" name="Correo" class="form-control mb-3" placeholder="Correo" required>

        <input type="password" name="Contrasena" class="form-control mb-3" placeholder="Contraseña" required>

        <select name="Rol" class="form-select mb-3">
            <option value="Cliente">Cliente</option>
            <option value="Admin">Admin</option>
        </select>

        <select name="Estado" class="form-select mb-4">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <button type="submit" class="btn btn-outline-light w-100">
            Guardar Usuario
        </button>

    </form>

</div>

<?php require __DIR__ . "/../../Layouts/footer.php"; ?>
