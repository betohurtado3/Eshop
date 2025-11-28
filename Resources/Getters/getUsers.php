<?php

require __DIR__ . "/../../config/config.php";


$query = $conn->prepare("SELECT Id, Nombre, Correo, Usuario, Rol, Estado, FechaCreacion FROM Usuarios");
$query->execute();

$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
return $usuarios; // 🔥 ESTO ES OBLIGATORIO