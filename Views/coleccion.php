<?php
$title = "Colección - Minerva Streetwear";

require __DIR__ . "/Layouts/header.php";
require __DIR__ . "/Layouts/navbar.php";
require __DIR__ . "/../Config/config.php";

// 🔐 Validar ID
if (!isset($_GET['Id']) || !is_numeric($_GET['Id'])) {
    header("Location: colecciones.php");
    exit;
}

$id = intval($_GET['Id']);

// ✅ Traer colección
$stmt = $conn->prepare("
    SELECT Id, Nombre, Descripcion 
    FROM Colecciones 
    WHERE Id = ? AND Estado = 1 
    LIMIT 1
");
$stmt->execute([$id]);
$coleccion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$coleccion) {
    header("Location: colecciones.php");
    exit;
}

// ✅ Traer imagen principal de la colección
$stmtImg = $conn->prepare("
    SELECT Nombre 
    FROM Imagenes 
    WHERE Tipo = 'Coleccion' 
      AND Id_Relacionado = ?
    ORDER BY Id ASC
    LIMIT 1
");
$stmtImg->execute([$id]);
$imagenColeccion = $stmtImg->fetchColumn();

// ✅ Traer productos de esta colección
$stmtProd = $conn->prepare("
    SELECT 
        p.Id,
        p.Nombre,
        p.Precio,

        (
            SELECT i.Nombre 
            FROM Imagenes i 
            WHERE i.Tipo = 'Producto' 
              AND i.Id_Relacionado = p.Id
            ORDER BY i.Id ASC
            LIMIT 1
        ) AS Imagen

    FROM Productos p
    WHERE p.Id_Coleccion = ?
      AND p.Estado = 1
    ORDER BY p.FechaCreacion DESC
");
$stmtProd->execute([$id]);
$productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HERO DE COLECCIÓN -->
<section class="py-5 text-light" style="background:#0e0e0e;">
    <div class="container text-center">

        <h1 class="fw-bold"><?= htmlspecialchars($coleccion['Nombre']) ?></h1>
        <p class="text-secondary mt-2" style="max-width:600px;margin:auto;">
            <?= htmlspecialchars($coleccion['Descripcion']) ?>
        </p>
    </div>
</section>

<!-- PRODUCTOS DE LA COLECCIÓN -->
<section class="py-5 bg-dark">
    <div class="container">

        

        <div class="text-center mb-5">
            <h3 class="fw-bold text-light">Productos de esta colección</h3>
        </div>

        <div class="row g-4">

            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $prod): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product-card-dark p-3 h-100 text-center">

                            <?php if ($prod['Imagen']): ?>
                                <img src="/eShop/Resources/img/Products/<?= $prod['Imagen'] ?>" 
                                     class="img-fluid mb-3 rounded">
                            <?php endif; ?>

                            <h6 class="text-light"><?= htmlspecialchars($prod['Nombre']) ?></h6>
                            <p class="text-secondary">$<?= number_format($prod['Precio'],2) ?> MXN</p>

                            <a href="producto.php?Id=<?= $prod['Id'] ?>" 
                               class="btn btn-outline-light btn-sm">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-secondary">
                    No hay productos disponibles en esta colección.
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require __DIR__ . "/Layouts/footer.php"; ?>
