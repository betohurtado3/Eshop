<?php
session_start();
require "../../../Config/config.php";

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    $_SESSION['Mensaje'] = "Acceso no autorizado.";
    $_SESSION['TipoMensaje'] = "danger";
    header("Location: /eShop/index.php");
    exit;
}

$id       = $_POST['Id'];
$nombre   = $_POST['Nombre'];
$usuario  = $_POST['Usuario'];
$correo   = $_POST['Correo'];
$rol      = $_POST['Rol'];
$estado   = $_POST['Estado'];
$password = $_POST['Contrasena'];

try {

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE Usuarios 
                SET Nombre=?, Usuario=?, Correo=?, Rol=?, Estado=?, Contrasena=? 
                WHERE Id=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $usuario, $correo, $rol, $estado, $hash, $id]);

    } else {

        $sql = "UPDATE Usuarios 
                SET Nombre=?, Usuario=?, Correo=?, Rol=?, Estado=? 
                WHERE Id=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $usuario, $correo, $rol, $estado, $id]);
    }

    // ✅ MENSAJE DE ÉXITO
    $_SESSION['Mensaje'] = "Usuario actualizado correctamente.";
    $_SESSION['TipoMensaje'] = "success";

} catch (Exception $e) {

    // ❌ MENSAJE DE ERROR
    $_SESSION['Mensaje'] = "Error al actualizar el usuario.";
    $_SESSION['TipoMensaje'] = "danger";
}

// 🔁 REGRESAMOS AL INDEX
header("Location: index.php");
exit;
