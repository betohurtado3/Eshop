<?php
require __DIR__ . "/../../config/config.php";

$query = $conn->prepare("
    SELECT Id, Nombre, Precio, Coleccion, Estado
    FROM Productos 
    WHERE Estado = 1
    ORDER BY FechaCreacion DESC
    LIMIT 4
");
$query->execute();

$productos = $query->fetchAll(PDO::FETCH_ASSOC);

return $productos;
