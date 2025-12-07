<?php
require __DIR__ . "/../../config/config.php";

$query = $conn->prepare("
    SELECT 
        c.Id,
        c.Nombre,
        c.Descripcion,
        c.Estado,
        c.FechaCreacion,

        (
            SELECT i.Nombre
            FROM Imagenes i
            WHERE i.Tipo = 'Coleccion'
              AND i.Id_Relacionado = c.Id
            ORDER BY i.Id ASC
            LIMIT 1
        ) AS Imagen

    FROM Colecciones c
    WHERE c.Estado = 1
    ORDER BY c.FechaCreacion DESC
");

$query->execute();
$colecciones = $query->fetchAll(PDO::FETCH_ASSOC);

return $colecciones;
