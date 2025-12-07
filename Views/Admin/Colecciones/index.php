<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

// Traemos colecciones activas
$colecciones = require "../../../Resources/Getters/getCollections.php";
?>

<?php
require "../../Layouts/header.php";
require "../../Layouts/navbar.php";
?>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Módulo de Colecciones</h2>

        <button class="btn btn-dark" data-bs-toggle="collapse" data-bs-target="#formNuevaColeccion">
            <i class="bi bi-plus-circle"></i> Nueva Colección
        </button>
    </div>

    <!-- ✅ MENSAJES POR SESIÓN -->
    <?php if (isset($_SESSION['Mensaje'])): ?>
        <div class="alert alert-<?= $_SESSION['TipoMensaje']; ?> text-center">
            <?= $_SESSION['Mensaje']; ?>
        </div>
        <?php
        unset($_SESSION['Mensaje']);
        unset($_SESSION['TipoMensaje']);
        ?>
    <?php endif; ?>


    <!-- ✅ COLLAPSE: CREAR COLECCIÓN -->
    <div class="collapse mb-4" id="formNuevaColeccion">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Nueva Colección</h5>

                <!-- IMPORTANTE: enctype -->
                <form action="store.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <input type="text" name="Nombre" class="form-control" placeholder="Nombre de la colección" required>
                        </div>

                        <div class="col-md-6">
                            <select name="Estado" class="form-select">
                                <option value="1">Activa</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <textarea name="Descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
                        </div>

                        <!-- ✅ INPUT IMAGEN -->
                        <div class="col-12">
                            <label class="fw-semibold">Imagen de la colección</label>
                            <input
                                type="file"
                                name="Imagen"
                                class="form-control"
                                accept="image/*"
                                required>
                            <small class="text-muted">Formato JPG, PNG, WEBP</small>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- ✅ TABLA DE COLECCIONES -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="70">Img</th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th width="180">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($colecciones as $c): ?>
                        <tr>

                            <!-- ✅ COLUMNA IMAGEN MINI -->
                            <td class="text-center">
                                <?php if (!empty($c['Imagen'])): ?>
                                    <div class="thumb-wrapper">
                                        <img style="max-width: 60px; border-radius: 8px;"
                                        src="/eShop/Resources/Img/Colecciones/<?= htmlspecialchars($c['Imagen']); ?>">
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small">Sin img</span>
                                <?php endif; ?>
                            </td>


                            <td><?= $c['Id']; ?></td>
                            <td><?= htmlspecialchars($c['Nombre']); ?></td>
                            <td><?= htmlspecialchars($c['Descripcion']); ?></td>

                            <td>
                                <?php if ($c['Estado'] == 'Activo'): ?>
                                    <span class="badge bg-success">Activa</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactiva</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $c['FechaCreacion']; ?></td>

                            <td>
                                <!-- EDITAR -->
                                <button class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#edit<?= $c['Id']; ?>">
                                    <i class="bi bi-pencil">Editar</i>
                                </button>

                                <!-- ELIMINAR -->
                                <a href="delete.php?id=<?= $c['Id']; ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Eliminar colección?')">
                                    <i class="bi bi-trash">Eliminar</i>
                                </a>
                            </td>
                        </tr>


                        <!-- ✅ COLLAPSE EDITAR -->
                        <tr class="collapse bg-light" id="edit<?= $c['Id']; ?>">
                            <td colspan="6">

                                <form action="update.php" method="POST" class="p-3" enctype="multipart/form-data">
                                    <input type="hidden" name="Id" value="<?= $c['Id']; ?>">

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <input type="text" name="Nombre" class="form-control"
                                                value="<?= htmlspecialchars($c['Nombre']); ?>" required>
                                        </div>

                                        <div class="col-md-4">
                                            <select name="Estado" class="form-select">
                                                <option value="1" <?= $c['Estado'] == 'Activo' ? 'selected' : '' ?>>Activa</option>
                                                <option value="0" <?= $c['Estado'] == 'Inactivo' ? 'selected' : '' ?>>Inactiva</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" name="Descripcion" class="form-control"
                                                value="<?= htmlspecialchars($c['Descripcion']); ?>">
                                        </div>

                                        <!-- 🖼️ PREVIEW + INPUT IMAGEN -->
                                        <div class="col-md-6 mt-3">
                                            <?php if (!empty($c['Imagen'])): ?>
                                                <p class="mb-1 small text-muted">Imagen actual:</p>
                                                <img src="/eShop/Resources/Img/Coleccions/<?= htmlspecialchars($c['Imagen']); ?>"
                                                    alt="Imagen colección"
                                                    style="max-width: 100%; border-radius: 8px;">
                                            <?php else: ?>
                                                <p class="mb-1 small text-muted">Esta colección aún no tiene imagen.</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label class="form-label small">Cambiar imagen</label>
                                            <input type="file" name="NuevaImagen" class="form-control" accept="image/*">
                                        </div>

                                        <div class="col-12 text-end mt-3">
                                            <button class="btn btn-success btn-sm">
                                                <i class="bi bi-save"></i> Actualizar
                                            </button>
                                        </div>
                                    </div>
                                </form>


                            </td>
                        </tr>

                        <script>
                            document.querySelector("input[name='NuevaImagen'][form='editForm<?= $c['Id']; ?>']")
                        </script>


                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

<?php require "../../Layouts/footer.php"; ?>