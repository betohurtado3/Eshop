<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

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

$_SESSION['Mensaje'] = "Producto creado correctamente.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
