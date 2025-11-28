<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$id          = $_POST['Id'];
$nombre      = $_POST['Nombre'];
$descripcion = $_POST['Descripcion'];
$estado      = $_POST['Estado'];

$sql = "UPDATE Colecciones 
        SET Nombre = ?, Descripcion = ?, Estado = ?
        WHERE Id = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$nombre, $descripcion, $estado, $id]);

$_SESSION['Mensaje'] = "Colección actualizada correctamente.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
