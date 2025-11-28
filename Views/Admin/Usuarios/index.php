<?php
require __DIR__ . "/../../../Config/admin_guard.php";
require __DIR__ . "/../../Layouts/header.php";
require __DIR__ . "/../../Layouts/navbar.php";

if (isset($_SESSION['Mensaje'])): ?>
<br><br><br>
    <div class="alert alert-<?= $_SESSION['TipoMensaje']; ?> alert-dismissible fade show text-center" role="alert">
        <?= $_SESSION['Mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php 
    unset($_SESSION['Mensaje']);
    unset($_SESSION['TipoMensaje']);
endif; 

$usuarios = include __DIR__ . "/../../../Resources/Getters/getUsers.php";
?>

<div class="container py-5">

    <?php if (isset($_SESSION['Mensaje'])): ?>
        <div class="alert alert-<?= $_SESSION['TipoMensaje']; ?> alert-dismissible fade show text-center shadow-sm" role="alert">
            <?= $_SESSION['Mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php
        unset($_SESSION['Mensaje']);
        unset($_SESSION['TipoMensaje']);
    endif;
    ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Gestión de Usuarios</h2>
        <a href="create.php" class="btn btn-dark">
            <i class="bi bi-plus-circle me-2"></i> Nuevo Usuario
        </a>
    </div>



    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Creación</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= $u['Id']; ?></td>
                            <td><?= htmlspecialchars($u['Nombre']); ?></td>
                            <td><?= htmlspecialchars($u['Usuario']); ?></td>
                            <td><?= htmlspecialchars($u['Correo']); ?></td>
                            <td>
                                <span class="badge bg-<?= $u['Rol'] === 'Admin' ? 'danger' : 'secondary' ?>">
                                    <?= $u['Rol']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $u['Estado'] == 1 ? 'success' : 'secondary' ?>">
                                    <?= $u['Estado'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td><?= $u['FechaCreacion']; ?></td>
                            <td class="text-end">
                                <a href="#"
                                    class="btn btn-sm btn-outline-primary btn-edit-user"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal"

                                    data-id="<?= $u['Id']; ?>"
                                    data-nombre="<?= htmlspecialchars($u['Nombre']); ?>"
                                    data-usuario="<?= htmlspecialchars($u['Usuario']); ?>"
                                    data-correo="<?= htmlspecialchars($u['Correo']); ?>"
                                    data-rol="<?= $u['Rol']; ?>"
                                    data-estado="<?= $u['Estado']; ?>">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>


                                <a href="delete.php?id=<?= $u['Id']; ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    <i class="bi bi-trash">Eliminar</i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay usuarios registrados
                            </td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-dark">Editar Usuario</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-dark">
                <form action="update.php" method="POST">

                    <input type="hidden" name="Id" id="editId">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" name="Nombre" id="editNombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Usuario</label>
                            <input type="text" name="Usuario" id="editUsuario" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Correo</label>
                            <input type="email" name="Correo" id="editCorreo" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Rol</label>
                            <select name="Rol" id="editRol" class="form-select">
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Estado</label>
                            <select name="Estado" id="editEstado" class="form-select">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Nueva Contraseña (opcional)</label>
                            <input type="password" name="Contrasena" class="form-control">
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-dark px-4">Guardar Cambios</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const editButtons = document.querySelectorAll(".btn-edit-user");

        editButtons.forEach(btn => {
            btn.addEventListener("click", () => {

                document.getElementById("editId").value = btn.dataset.id;
                document.getElementById("editNombre").value = btn.dataset.nombre;
                document.getElementById("editUsuario").value = btn.dataset.usuario;
                document.getElementById("editCorreo").value = btn.dataset.correo;
                document.getElementById("editRol").value = btn.dataset.rol;
                document.getElementById("editEstado").value = btn.dataset.estado;

            });
        });

    });
</script>

<?php require __DIR__ . "/../../Layouts/footer.php"; ?>