<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar-custom">
    <div class="container-fluid nav-container">

        <!-- Left Menu -->
        <ul class="nav-left">
            <li><a href="/eShop/index.php">Inicio</a></li>
            <li><a href="/eShop/Views/colecciones.php">Colecciones</a></li>
            <li><a href="/eShop/Views/productos.php">Productos</a></li>
        </ul>

        <!-- Center Logo -->
        <div class="nav-logo">
            <a href="#">
                <img src="/eShop/Resources/img/Ritten.png" alt="Logo" />
            </a>
        </div>

        <!-- Right Icons -->
        <ul class="nav-right">
            <li><a href="#" class="icon"><i class="bi bi-search"></i></a></li>
            <li class="nav-item dropdown">

                <?php if (!isset($_SESSION['Usuario'])): ?>

                    <!-- CUANDO NO HAY SESIÓN -->
                    <a href="#" class="icon" data-bs-toggle="modal" data-bs-target="#authModal">
                        <i class="bi bi-person"></i>
                    </a>

                <?php else: ?>

                    <!-- CUANDO SÍ HAY SESIÓN -->
                    <a class="icon dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                        Hola, <?= $_SESSION['Usuario']; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item" href="/Views/Profile/profile.php">
                                <i class="bi bi-person-circle me-2"></i> Mi Perfil
                            </a>
                        </li>

                        <?php if ($_SESSION['Rol'] === 'Admin'): ?>
                            <li>
                                <a class="dropdown-item" href="/eShop/Views/Admin/dashboard.php">
                                    <i class="bi bi-speedometer2 me-2"></i> Panel Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item text-danger" href="/eShop/Views/Auth/logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>

                <?php endif; ?>

            </li>

            <li><a href="#" class="icon"><i class="bi bi-heart"></i></a></li>
            <li><a href="#" class="icon"><i class="bi bi-bag"></i></a></li>
        </ul>

    </div>
</nav>

<!-- Modal para Icono de Usuario -->
<div class="modal fade" id="authModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <?php if (isset($_SESSION['Mensaje'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['TipoMensaje']; ?> text-center mb-3" role="alert">
                        <?php echo $_SESSION['Mensaje']; ?>
                    </div>
                <?php
                    unset($_SESSION['Mensaje']);
                    unset($_SESSION['TipoMensaje']);
                endif;
                ?>


                <!-- ICONO SUPERIOR DEL MODAL -->
                <div class="text-center mb-4">
                    <div id="modalIcon" class="modal-icon mx-auto">

                        <!-- ICONO USUARIO -->
                        <svg id="iconUser" xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 16 16"
                            class="icon-user">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            <path d="M14 14s-1-4-6-4-6 4-6 4" />
                        </svg>

                        <!-- ICONO + -->
                        <span id="iconPlus" class="icon-plus d-none">+</span>
                    </div>
                </div>

                <!-- OPCIONES -->
                <div id="authOptions" class="text-center">
                    <p class="text-muted mb-4">Accede a tu cuenta o crea una nueva</p>

                    <button class="btn btn-dark w-100 mb-2" onclick="showLogin()">Iniciar Sesión</button>
                    <button class="btn btn-outline-dark w-100" onclick="showRegister()">Crear Cuenta</button>
                </div>

                <!-- LOGIN -->
                <div id="loginForm" class="d-none">
                    <form action="/eShop/Views/Auth/login.php" method="POST">

                        <!-- Usuario o Correo -->
                        <input type="text" name="login" class="form-control mb-2" placeholder="Usuario o correo"
                            required>

                        <!-- Contraseña -->
                        <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña"
                            required>

                        <button type="submit" class="btn btn-dark w-100">
                            Entrar
                        </button>

                        <p class="text-center mt-3">
                            <button type="button" class="btn btn-outline-dark w-100" onclick="backToOptions()">
                                Volver
                            </button>
                        </p>
                    </form>
                </div>

                <!-- REGISTER -->
                <div id="registerForm" class="d-none">
                    <form>
                        <input type="text" class="form-control mb-2" placeholder="Nombre">
                        <input type="email" class="form-control mb-2" placeholder="Correo">
                        <input type="password" class="form-control mb-3" placeholder="Contraseña">
                        <button class="btn btn-dark w-100">Crear Cuenta</button>

                        <p class="text-center mt-3">
                            <a href="#" class="btn btn-outline-dark w-100" onclick="backToOptions()">Volver</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
// 👇 leemos la bandera y luego la limpiamos
$mostrarAuthModal = $_SESSION['MostrarAuthModal'] ?? null;
unset($_SESSION['MostrarAuthModal']);
?>

<?php if ($mostrarAuthModal === "login"): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const authModalEl = document.getElementById("authModal");
    if (!authModalEl) return;

    // Asegúrate de que Bootstrap JS ya esté cargado antes de este script
    const authModal = new bootstrap.Modal(authModalEl);
    authModal.show();

    // Mostrar directamente el formulario de login (y ocultar opciones)
    if (typeof showLogin === "function") {
        showLogin();
    } else {
        // Por si acaso showLogin no está disponible
        const authOptions = document.getElementById("authOptions");
        const loginForm  = document.getElementById("loginForm");

        if (authOptions) authOptions.classList.add("d-none");
        if (loginForm)   loginForm.classList.remove("d-none");
    }
});
</script>
<?php endif; ?>
