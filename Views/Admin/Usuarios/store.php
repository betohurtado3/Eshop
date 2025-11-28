<?php
require __DIR__ . "/../../../Config/admin_guard.php";
require __DIR__ . "/../../../Config/config.php";

$nombre  = $_POST['Nombre'];
$usuario = $_POST['Usuario'];
$correo  = $_POST['Correo'];
$pass    = password_hash($_POST['Contrasena'], PASSWORD_DEFAULT);
$rol     = $_POST['Rol'];
$estado  = $_POST['Estado'];

$sql = "INSERT INTO Usuarios 
(Nombre, Usuario, Correo, Contrasena, Rol, Estado, FechaCreacion)
VALUES (:nombre, :usuario, :correo, :pass, :rol, :estado, NOW())";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':nombre'  => $nombre,
    ':usuario' => $usuario,
    ':correo'  => $correo,
    ':pass'    => $pass,
    ':rol'     => $rol,
    ':estado'  => $estado
]);

header("Location: index.php");
exit;
