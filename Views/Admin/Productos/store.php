<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

/* ================================
   1. INSERTAR PRODUCTO
================================ */

$sql = "INSERT INTO Productos 
(Nombre, Slug, Coleccion, DescripcionCorta, DescripcionLarga, Precio, Stock, Estado, FechaCreacion)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['Nombre'],
    $_POST['Slug'],
    $_POST['Coleccion'],
    $_POST['DescripcionCorta'],
    $_POST['DescripcionLarga'],
    $_POST['Precio'],
    $_POST['Stock'],
    $_POST['Estado']
]);

// ✅ OBTENEMOS EL ID DEL PRODUCTO RECIÉN INSERTADO
$idProducto = $conn->lastInsertId();

/* ================================
   2. PROCESAR IMÁGENES
================================ */

$carpetaDestino = "../../../Resources/img/Products/";

if (!empty($_FILES['Imagenes']['name'][0])) {

    $totalImagenes = count($_FILES['Imagenes']['name']);

    for ($i = 0; $i < $totalImagenes; $i++) {

        $nombreOriginal = $_FILES['Imagenes']['name'][$i];
        $tmpPath        = $_FILES['Imagenes']['tmp_name'][$i];
        $error          = $_FILES['Imagenes']['error'][$i];

        if ($error === 0) {

            // ✅ Generar nombre único
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nuevoNombre = uniqid("prod_") . "." . $extension;

            // ✅ Mover archivo
            move_uploaded_file($tmpPath, $carpetaDestino . $nuevoNombre);

            // ✅ Determinar si es imagen principal
            $esPrincipal = ($i === 0) ? 1 : 0;
            $orden = $i + 1;

            // ✅ Insertar en tabla Imagenes
            $sqlImg = "INSERT INTO Imagenes
            (Nombre, Tipo, Id_Relacionado, EsPrincipal, Orden, FechaCreacion)
            VALUES (?, 'Producto', ?, ?, ?, NOW())";

            $stmtImg = $conn->prepare($sqlImg);
            $stmtImg->execute([
                $nuevoNombre,
                $idProducto,
                $esPrincipal,
                $orden
            ]);
        }
    }
}

/* ================================
   3. MENSAJE + REDIRECCIÓN
================================ */

$_SESSION['Mensaje'] = "Producto creado correctamente con imágenes.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
