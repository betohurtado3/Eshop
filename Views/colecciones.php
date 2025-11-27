<?php
$title = "Colecciones - Minerva Streetwear";

require "Layouts/header.php";
require "Layouts/navbar.php";

// Traemos las colecciones desde el getter
$colecciones = require __DIR__ . "/../Resources/Getters/getCollections.php";
?>

<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-light">Colecciones</h1>
        <p class="text-muted">Explora nuestros drops exclusivos</p>
    </div>

    <div class="row g-4">

        <?php if (!empty($colecciones)): ?>
            <?php foreach ($colecciones as $col): ?>
                <div class="col-md-4">
                    <div class="collection-card-dark p-4 h-100 text-center">
                        <h4 class="mb-2"><?= htmlspecialchars($col['Nombre']) ?></h4>
                        <p class="small text-secondary">
                            <?= htmlspecialchars($col['Descripcion']) ?>
                        </p>

                        <a href="productos.php?coleccion=<?= $col['Id'] ?>" 
                           class="btn btn-outline-light mt-3">
                           Ver colección
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">
                No hay colecciones disponibles por el momento
            </div>
        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . "/Layouts/footer.php"; ?>
