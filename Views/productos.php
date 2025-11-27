<?php
$title = "Colecciones - Minerva Streetwear";

require "Layouts/header.php";
require "Layouts/navbar.php";

// Traemos los productos desde el getter
$productos = require __DIR__ . "/../Resources/Getters/getProductos.php";
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-light">Productos</h1>
        <p class="text-muted">Explora nuestras exclusivas prendas</p>
    </div>

    <div class="row g-4">

        <?php if (!empty($productos)) : ?>
            <?php foreach ($productos as $producto) : ?>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="product-card">

                        <!-- Imagen temporal (luego se conecta a la tabla Imagenes) -->
                        <div class="product-img">
                            <div class="placeholder-img"></div>
                        </div>

                        <div class="product-info">
                            <h5 class="product-title">
                                <?= htmlspecialchars($producto['Nombre']) ?>
                            </h5>

                            <p class="product-collection ">
                                <?= htmlspecialchars($producto['Coleccion']) ?>
                            </p>

                            <div class="product-price">
                                $<?= number_format($producto['Precio'], 2) ?> MXN
                            </div>

                            <button class="btn btn-outline-light w-100 mt-3 btn-sm">
                                Ver producto
                            </button>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center text-muted">
                <p>No hay productos disponibles por el momento.</p>
            </div>
        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . "/Layouts/footer.php"; ?>
