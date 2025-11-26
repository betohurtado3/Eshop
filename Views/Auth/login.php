<?php
session_start();
require_once __DIR__ . "/../../Config/config.php"; // Ajusta si tu ruta cambia

// echo password_hash("123456", PASSWORD_DEFAULT); Encriptador de contraseñas

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /eShop/index.php");
    exit;
}

$login    = trim($_POST["login"] ?? "");
$password = trim($_POST["password"] ?? "");

if (empty($login) || empty($password)) {
    die("Todos los campos son obligatorios.");
}

// 🔎 Detectar si es correo o usuario
if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT * FROM Usuarios WHERE Correo = :login AND Estado = 1 LIMIT 1";
} else {
    $sql = "SELECT * FROM Usuarios WHERE Usuario = :login AND Estado = 1 LIMIT 1";
}

$stmt = $conn->prepare($sql);
$stmt->bindParam(":login", $login);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario o correo no encontrado.");
}

// ✅ Verificar contraseña
if (!password_verify($password, $usuario["Contrasena"])) {
    die("Contraseña incorrecta.");
}

// ✅ Crear sesión segura
$_SESSION["Id"]      = $usuario["Id"];
$_SESSION["Nombre"] = $usuario["Nombre"];
$_SESSION["Usuario"]= $usuario["Usuario"];
$_SESSION["Rol"]    = $usuario["Rol"];
$_SESSION["Estado"] = $usuario["Estado"];

// 🔐 Regenerar ID de sesión (seguridad)
session_regenerate_id(true);

// ✅ Redirección por rol
if ($usuario["Rol"] === "Admin") {
   header("Location: /eShop/Views/Admin/dashboard.php");
} else {
    header("Location: /eShop/Views/home.php");
}

exit;
