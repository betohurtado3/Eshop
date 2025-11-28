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

$sql = "INSERT INTO Colecciones (Nombre, Descripcion, Estado, FechaCreacion)
        VALUES (?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([$nombre, $descripcion, $estado]);

$_SESSION['Mensaje'] = "Colección creada correctamente.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
