<?php
require __DIR__ . "/Layouts/header.php";
require __DIR__ . "/Layouts/navbar.php";
require __DIR__ . "/../Config/config.php";

if (!isset($_GET['Id'])) {
    header("Location: /eShop/index.php");
    exit;
}

$id = intval($_GET['Id']);


// ✅ 1. TRAER PRODUCTO
$stmt = $conn->prepare("
    SELECT * 
    FROM Productos 
    WHERE Id = ? AND Estado = 1
    LIMIT 1
");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    header("Location: /eShop/index.php");
    exit;
}


// ✅ 2. TRAER IMÁGENES DEL PRODUCTO
$stmtImg = $conn->prepare("
    SELECT Nombre 
    FROM Imagenes 
    WHERE Tipo = 'Producto' 
      AND Id_Relacionado = ?
");
$stmtImg->execute([$id]);
$imagenes = $stmtImg->fetchAll(PDO::FETCH_ASSOC);


// ✅ 3. TRAER PRODUCTOS RELACIONADOS POR COLECCIÓN
$stmtRelacionados = $conn->prepare("
    SELECT 
        p.Id,
        p.Nombre,
        p.Precio,
        (
            SELECT i.Nombre 
            FROM Imagenes i 
            WHERE i.Tipo = 'Producto' 
              AND i.Id_Relacionado = p.Id
            LIMIT 1
        ) AS Imagen
    FROM Productos p
    WHERE p.Id_Coleccion = ?
      AND p.Id != ?
      AND p.Estado = 1
    LIMIT 4
");
$stmtRelacionados->execute([
    $producto['Id_Coleccion'],
    $producto['Id']
]);
$relacionados = $stmtRelacionados->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">

    <!-- PRODUCTO DETALLE -->
    <div class="row g-5">

        <!-- GALERÍA -->
        <div class="col-md-6">
            <div id="carouselProducto" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php if(count($imagenes) > 0): ?>
                        <?php foreach($imagenes as $index => $img): ?>
                            <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                <img 
                                    src="/eShop/Resources/img/Products/<?= $img['Nombre'] ?>" 
                                    class="d-block w-100 rounded"
                                    style="object-fit:cover; height:500px;"
                                >
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <div style="height:500px;background:#222;"></div>
                        </div>
                    <?php endif; ?>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>

        <!-- INFO PRODUCTO -->
        <div class="col-md-6 text-light">
            <h1 class="fw-bold"><?= htmlspecialchars($producto['Nombre']) ?></h1>
            <p class="text-muted mb-2"><?= htmlspecialchars($producto['DescripcionCorta']) ?></p>

            <h3 class="my-3">$<?= number_format($producto['Precio'], 2) ?> MXN</h3>

            <p><?= nl2br(htmlspecialchars($producto['DescripcionLarga'])) ?></p>

            <p class="mt-3">
                <strong>Stock:</strong> <?= $producto['Stock'] ?>
            </p>

            <p>
                <strong>Colección:</strong> <?= $producto['Coleccion'] ?>
            </p>

            <div class="mt-4">
                <button class="btn btn-light btn-lg w-100">
                    Agregar al carrito
                </button>
            </div>
        </div>
    </div>


    <!-- PRODUCTOS RELACIONADOS -->
    <?php if(count($relacionados) > 0): ?>
        <div class="mt-5">
            <h3 class="fw-bold text-light mb-4">Más de esta colección</h3>

            <div class="row g-4">
                <?php foreach($relacionados as $rel): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="product-card p-3 border rounded text-center text-light">

                            <?php if($rel['Imagen']): ?>
                                <img 
                                  src="/eShop/Resources/img/Products/<?= $rel['Imagen'] ?>" 
                                  class="mb-3 w-100 rounded"
                                  style="height:160px;object-fit:cover;"
                                >
                            <?php else: ?>
                                <div style="height:160px;background:#333;"></div>
                            <?php endif; ?>

                            <h6><?= htmlspecialchars($rel['Nombre']) ?></h6>
                            <p>$<?= number_format($rel['Precio'],2) ?> MXN</p>

                            <a href="/eShop/Views/producto.php?Id=<?= $rel['Id'] ?>" 
                               class="btn btn-outline-light btn-sm">
                                Ver
                            </a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require __DIR__ . "/Layouts/footer.php"; ?>
