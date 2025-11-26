<?php

require __DIR__ . "/../../config/config.php";


$query = $conn->prepare("SELECT Id, Usuario, Rol, Estado FROM Usuarios");
$query->execute();

$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($usuarios);
echo "</pre>";
