<?php
$title = "Inicio - Minerva Streetwear";

require __DIR__ . "/Views/Layouts/header.php";
require __DIR__ . "/Views/Layouts/navbar.php";

require __DIR__ . "/Resources/Getters/getCollections.php";
require __DIR__ . "/Resources/Getters/getProductos.php";

// Llamamos los getters (IMPORTANTE: cada getter retorna la info)
$colecciones = include __DIR__ . "/Resources/Getters/getCollections.php";
$productos = include __DIR__ . "/Resources/Getters/getProductos.php";

?>
<div class="container py-5">
    <!-- HERO SECTION -->
    <section class="hero-section position-relative d-flex align-items-center justify-content-center text-center">
        <div class="hero-content text-white">
            <h1 class="display-3 fw-bold">Nueva Colección 2025</h1>
            <p class="lead">Streetwear para artistas y cultura urbana</p>
            <button class="btn btn-light px-4 py-2 mt-3">Explorar</button>
        </div>
    </section>

    <!-- COLECCIONES DESTACADAS -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Colecciones</h2>
                <p class="text-muted">Explora drops exclusivos y lanzamientos limitados</p>
            </div>

            <div class="row g-4">
                <?php foreach ($colecciones as $col): ?>
                    <div class="col-md-4">
                        <div class="collection-card p-4 border rounded text-center">
                            <h4><?= htmlspecialchars($col['Nombre']) ?></h4>
                            <p><?= htmlspecialchars($col['Descripcion']) ?></p>
                            <button class="btn btn-dark">Ver más</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- SECCIÓN OFERTAS Y DESCUENTOS -->
<div class="row g-4">
    <?php foreach ($productos as $prod): ?>

        <?php 
            $rutaImagen = "/eShop/Resources/img/Products/" . ($prod['Imagen'] ?? '');
            $imagenFinal = (!empty($prod['Imagen']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $rutaImagen))
                ? $rutaImagen
                : "/eShop/Resources/img/no-image.jpg"; // fallback
        ?>

        <div class="col-md-3 col-sm-6">
            <div class="product-card p-3 border rounded text-center">

                <!-- IMAGEN REAL -->
                <img src="<?= $imagenFinal ?>" 
                     class="img-fluid mb-3 product-img"
                     alt="<?= htmlspecialchars($prod['Nombre']) ?>">

                <h5 class="fw-semibold text-light">
                    <?= htmlspecialchars($prod['Nombre']) ?>
                </h5>

                <p class="text-light">
                    $<?= number_format($prod['Precio'], 2) ?> MXN
                </p>

                    <a class="btn btn-outline-light btn-sm" href="/eShop/Views/producto.php?Id=<?= $prod['Id'] ?>">Detalles</a>

            </div>
        </div>

    <?php endforeach; ?>
</div>


</div>

<?php require __DIR__ . "/views/layouts/footer.php"; ?>