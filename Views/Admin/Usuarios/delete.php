<?php
session_start();
require __DIR__ . "/../../../Config/config.php";

// 🔒 Seguridad: solo Admin
if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    header("Location: /eShop/index.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['Mensaje'] = "ID inválido.";
    $_SESSION['TipoMensaje'] = "danger";
    header("Location: index.php");
    exit;
}

// ✅ Borrado lógico (Estado = 0)
$sql = "UPDATE Usuarios SET Estado = 0 WHERE Id = :id LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $_SESSION['Mensaje'] = "✅ Usuario desactivado correctamente.";
    $_SESSION['TipoMensaje'] = "success";
} else {
    $_SESSION['Mensaje'] = "❌ Error al desactivar el usuario.";
    $_SESSION['TipoMensaje'] = "danger";
}

header("Location: index.php");
exit;
