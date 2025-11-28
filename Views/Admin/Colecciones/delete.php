<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$id = $_GET['id'];

$sql = "UPDATE Colecciones SET Estado = 'Inactivo' WHERE Id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$_SESSION['Mensaje'] = "Colección eliminada correctamente.";
$_SESSION['TipoMensaje'] = "warning";

header("Location: index.php");
exit;
