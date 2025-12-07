<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$nombre      = $_POST['Nombre'];
$descripcion = $_POST['Descripcion'];
$estado      = $_POST['Estado'];

/* ===============================
   ✅ 1. GUARDAR COLECCIÓN
=================================*/
$sql = "INSERT INTO Colecciones (Nombre, Descripcion, Estado, FechaCreacion)
        VALUES (?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([$nombre, $descripcion, $estado]);

// ✅ OBTENEMOS EL ID DE LA COLECCIÓN RECIÉN CREADA
$idColeccion = $conn->lastInsertId();

/* ===============================
   ✅ 2. PROCESAR IMAGEN
=================================*/
if (!empty($_FILES['Imagen']['name'])) {

    $directorio = "../../../Resources/img/Coleccions/";

    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombreOriginal = $_FILES['Imagen']['name'];
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

    $nombreFinal = uniqid('coleccion_') . "." . $extension;

    $rutaFinal = $directorio . $nombreFinal;

    move_uploaded_file($_FILES['Imagen']['tmp_name'], $rutaFinal);

    /* ===============================
       ✅ 3. GUARDAR EN TABLA IMAGENES
    =================================*/
    $sqlImg = "INSERT INTO Imagenes 
                (Nombre, Tipo, Id_Relacionado, EsPrincipal, Orden, FechaCreacion)
               VALUES (?, 'Coleccion', ?, 1, 1, NOW())";

    $stmtImg = $conn->prepare($sqlImg);
    $stmtImg->execute([
        $nombreFinal,
        $idColeccion
    ]);
}

/* ===============================
   ✅ MENSAJE DE ÉXITO
=================================*/
$_SESSION['Mensaje'] = "Colección creada correctamente.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
