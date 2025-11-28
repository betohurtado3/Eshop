<?php
session_start();
require "../../../Config/config.php";

$id = $_GET['id'];

$stmt = $conn->prepare("UPDATE Productos SET Estado = 'Inactivo' WHERE Id = ?");
$stmt->execute([$id]);

$_SESSION['Mensaje'] = "Producto desactivado.";
$_SESSION['TipoMensaje'] = "warning";

header("Location: index.php");
exit;
