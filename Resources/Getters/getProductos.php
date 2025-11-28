<?php
require __DIR__ . "/../../Config/config.php";

$query = $conn->prepare("
    SELECT 
        p.Id,
        p.Nombre,
        p.Precio,
        p.Coleccion,
        p.Estado,

        -- Traemos SOLO UNA imagen (la primera)
        (
            SELECT i.Nombre 
            FROM Imagenes i 
            WHERE i.Tipo = 'Producto' 
              AND i.Id_Relacionado = p.Id
            ORDER BY i.Id ASC
            LIMIT 1
        ) AS Imagen

    FROM Productos p
    WHERE p.Estado = 1
    ORDER BY p.FechaCreacion DESC
    LIMIT 4
");

$query->execute();
$productos = $query->fetchAll(PDO::FETCH_ASSOC);

return $productos;
