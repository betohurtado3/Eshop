<?php
require __DIR__ . "/../../config/config.php";

$query = $conn->prepare("SELECT Id, Nombre, Descripcion, Estado,  FechaCreacion  FROM Colecciones WHERE Estado = 1 LIMIT 3");
$query->execute();

$colecciones = $query->fetchAll(PDO::FETCH_ASSOC);

return $colecciones;
