<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔒 PROTECCIÓN ANTES DE IMPRIMIR NADA
if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$title = "Panel Admin - Minerva Streetwear";

require "../Layouts/header.php";
require "../Layouts/navbar.php";

// Puedes cargar tus getters aquí sin problema
$colecciones = include "../../Resources/Getters/getCollections.php";
$productos   = include "../../Resources/Getters/getProductos.php";
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-light">Panel de Administración</h1>
        <p class="text-muted">Control general del sistema</p>
    </div>

    <div class="row g-4 justify-content-center">

        <!-- USUARIOS -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Usuarios</h5>
                    <p class="card-text text-muted">Gestión de cuentas, roles y accesos.</p>
                    <a href="/eShop/Views/Admin/Usuarios/index.php" class="btn btn-outline-dark">
                        Ir a Usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- PRODUCTOS -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-bag fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Productos</h5>
                    <p class="card-text text-muted">Alta, edición, stock y precios.</p>
                    <a href="/eShop/Views/Admin/Productos/index.php" class="btn btn-outline-dark">
                        Ir a Productos
                    </a>
                </div>
            </div>
        </div>

        <!-- COLECCIONES -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-collection fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Colecciones</h5>
                    <p class="card-text text-muted">Drops, categorías y banners.</p>
                    <a href="/eShop/Views/Admin/Colecciones/index.php" class="btn btn-outline-dark">
                        Ir a Colecciones
                    </a>
                </div>
            </div>
        </div>

        <!-- ÓRDENES -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-receipt fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Órdenes</h5>
                    <p class="card-text text-muted">Pedidos, estados y seguimiento.</p>
                    <a href="ordenes.php" class="btn btn-dark w-100">Ir al módulo</a>
                </div>
            </div>
        </div>

        <!-- ENVÍOS -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-truck fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Envíos</h5>
                    <p class="card-text text-muted">Guías, transportistas y estados.</p>
                    <a href="envios.php" class="btn btn-dark w-100">Ir al módulo</a>
                </div>
            </div>
        </div>

        <!-- PAGOS -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-credit-card fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Pagos</h5>
                    <p class="card-text text-muted">Transacciones y validaciones.</p>
                    <a href="pagos.php" class="btn btn-dark w-100">Ir al módulo</a>
                </div>
            </div>
        </div>

        <!-- DISTRIBUIDORES -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-box-seam fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Distribuidores</h5>
                    <p class="card-text text-muted">Proveedores y marcas.</p>
                    <a href="distribuidores.php" class="btn btn-dark w-100">Ir al módulo</a>
                </div>
            </div>
        </div>

        <!-- REPORTES -->
        <div class="col-md-4">
            <div class="card admin-card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-graph-up fs-1 mb-3"></i>
                    <h5 class="card-title fw-bold">Reportes</h5>
                    <p class="card-text text-muted">Ventas, métricas y analítica.</p>
                    <a href="reportes.php" class="btn btn-dark w-100">Ir al módulo</a>
                </div>
            </div>
        </div>

    </div>
</div>



<?php require "../layouts/footer.php"; ?>