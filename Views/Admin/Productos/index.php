<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$productos = include "../../../Resources/Getters/getProductos.php";
?>

<?php
require "../../Layouts/header.php";
require "../../Layouts/navbar.php";
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-light">Gestión de Productos</h2>
        <a href="create.php" class="btn btn-success">
            + Nuevo Producto
        </a>
    </div>

    <?php if (isset($_SESSION['Mensaje'])): ?>
        <div class="alert alert-<?= $_SESSION['TipoMensaje']; ?> text-center">
            <?= $_SESSION['Mensaje']; ?>
        </div>
        <?php unset($_SESSION['Mensaje'], $_SESSION['TipoMensaje']); ?>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Colección</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td>
                                <?php if (!empty($p['Imagen'])): ?>
                                    <img src="/eShop/Resources/img/Products/<?= $p['Imagen']; ?>" 
                                         width="60" class="rounded shadow-sm">
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($p['Nombre']); ?></td>
                            <td><?= htmlspecialchars($p['Coleccion']); ?></td>
                            <td>$<?= number_format($p['Precio'], 2); ?></td>

                            <td>
                                <span class="badge <?= $p['Estado'] ? 'bg-success' : 'bg-danger'; ?>">
                                    <?= $p['Estado'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>

                            <td>
                                <a href="edit.php?id=<?= $p['Id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil">Editar</i>
                                </a>

                                <a href="delete.php?id=<?= $p['Id']; ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Eliminar este producto?')">
                                    <i class="bi bi-trash">Eliminar</i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

<?php require "../../Layouts/footer.php"; ?>
