<?php
session_start();
require "../../../Config/config.php";

$sql = "UPDATE Productos SET
Nombre=?, Slug=?, Coleccion=?, DescripcionCorta=?, DescripcionLarga=?,
Precio=?, Stock=?, Estado=?
WHERE Id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $_POST['Nombre'],
    $_POST['Slug'],
    $_POST['Coleccion'],
    $_POST['DescripcionCorta'],
    $_POST['DescripcionLarga'],
    $_POST['Precio'],
    $_POST['Stock'],
    $_POST['Estado'],
    $_POST['Id']
]);

$_SESSION['Mensaje'] = "Producto actualizado correctamente.";
$_SESSION['TipoMensaje'] = "success";

header("Location: index.php");
exit;
