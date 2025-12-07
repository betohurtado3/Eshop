<?php
session_start();

// 🔍 MODO DEBUG A FULL
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre>";
echo "=== DEBUG UPDATE COLECCIÓN ===\n\n";

// 1) Cargar config
echo "1) Cargando config...\n";
require "../../../Config/config.php";
echo "   ✓ Config cargado\n\n";

// 2) Revisar sesión y rol
echo "2) Revisando sesión...\n";
var_dump($_SESSION);

if (!isset($_SESSION['Id']) || $_SESSION['Rol'] !== 'Admin') {
    echo "\n✗ Usuario NO autorizado. Cortando ejecución.\n";
    exit;
}
echo "   ✓ Usuario autorizado\n\n";

// 3) Revisar POST recibido
echo "3) Datos recibidos por POST:\n";
var_dump($_POST);

// 4) Revisar FILES recibido
echo "\n4) Datos recibidos en FILES:\n";
var_dump($_FILES);

$id          = $_POST['Id'] ?? null;
$nombre      = $_POST['Nombre'] ?? null;
$descripcion = $_POST['Descripcion'] ?? null;
$estado      = $_POST['Estado'] ?? null;

echo "\n5) Variables ya parseadas:\n";
echo "   Id          = {$id}\n";
echo "   Nombre      = {$nombre}\n";
echo "   Descripcion = {$descripcion}\n";
echo "   Estado      = {$estado}\n\n";

// 🟩 6. ACTUALIZAR DATOS BÁSICOS
echo "6) Ejecutando UPDATE de tabla Colecciones...\n";

$sql = "UPDATE Colecciones 
        SET Nombre = ?, Descripcion = ?, Estado = ?
        WHERE Id = ?";

$stmt = $conn->prepare($sql);
$ok = $stmt->execute([$nombre, $descripcion, $estado, $id]);

if (!$ok) {
    echo "   ✗ Error al hacer UPDATE de Colecciones:\n";
    var_dump($stmt->errorInfo());
} else {
    echo "   ✓ UPDATE Colecciones ejecutado\n";
    echo "   Filas afectadas: " . $stmt->rowCount() . "\n\n";
}

// 🟦 7. ¿VIENE IMAGEN NUEVA?
echo "7) Revisando si viene imagen NuevaImagen...\n";

if (!empty($_FILES['NuevaImagen']['name'])) {

    echo "   ✓ Sí viene archivo en NuevaImagen\n";

    $archivo = $_FILES['NuevaImagen'];

    echo "   Detalles del archivo:\n";
    var_dump($archivo);

    // Nombre final
    $nombreFinal = time() . "_" . basename($archivo['name']);

    // 👀 OJO: carpeta correcta => Colecciones (no 'Coleccions')
    $uploadDir = __DIR__ . "/../../../Resources/Img/Colecciones/";

    echo "\n   Carpeta de subida calculada:\n";
    echo "   uploadDir = {$uploadDir}\n";

    // Verificamos si existe la carpeta
    if (!is_dir($uploadDir)) {
        echo "   ✗ La carpeta NO existe. Intentando crearla...\n";
        if (!mkdir($uploadDir, 0777, true)) {
            echo "   ✗ No se pudo crear la carpeta de subida. Abortando.\n";
            exit;
        } else {
            echo "   ✓ Carpeta creada correctamente.\n";
        }
    } else {
        echo "   ✓ La carpeta existe.\n";
    }

    // ¿Se puede escribir ahí?
    if (!is_writable($uploadDir)) {
        echo "   ✗ La carpeta NO es escribible. Revisa permisos.\n";
    } else {
        echo "   ✓ La carpeta es escribible.\n";
    }

    $destino = $uploadDir . $nombreFinal;
    echo "   Ruta final del archivo: {$destino}\n\n";

    // 7.1 Mover archivo
    echo "7.1) Intentando mover archivo subido...\n";

    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
        echo "   ✓ Archivo movido correctamente.\n";
    } else {
        echo "   ✗ ERROR al mover el archivo. Revisa 'tmp_name' y permisos.\n";
        echo "   tmp_name: " . $archivo['tmp_name'] . "\n";
        echo "   error code: " . $archivo['error'] . " (0 = OK)\n";
        // En este punto no seguimos con borrado/UPDATE porque la imagen ni siquiera se subió bien
        exit;
    }

    // 7.2 Buscar imagen anterior en BD
    echo "\n7.2) Buscando imagen anterior en tabla Imagenes...\n";

    $query = $conn->prepare("SELECT Nombre FROM Imagenes WHERE Tipo='Coleccion' AND Id_Relacionado=? LIMIT 1");
    $query->execute([$id]);
    $imgAnterior = $query->fetchColumn();

    echo "   Imagen anterior encontrada (si existe): ";
    var_dump($imgAnterior);

    // 7.3 Eliminar archivo físico anterior si existe
    if ($imgAnterior) {
        $rutaAnterior = $uploadDir . $imgAnterior;
        echo "   Ruta archivo anterior: {$rutaAnterior}\n";

        if (file_exists($rutaAnterior)) {
            if (unlink($rutaAnterior)) {
                echo "   ✓ Imagen anterior eliminada del disco.\n";
            } else {
                echo "   ✗ No se pudo eliminar la imagen anterior del disco.\n";
            }
        } else {
            echo "   (i) El archivo anterior no existe físicamente.\n";
        }
    } else {
        echo "   (i) No había imagen anterior registrada.\n";
    }

    // 7.4 Actualizar/insertar registro en tabla Imagenes
    echo "\n7.4) Actualizando tabla Imagenes...\n";

    $sqlImg = "UPDATE Imagenes 
               SET Nombre=?, FechaCreacion=NOW()
               WHERE Tipo='Coleccion' AND Id_Relacionado=?";

    $stmtImg = $conn->prepare($sqlImg);
    $okImg = $stmtImg->execute([$nombreFinal, $id]);

    if (!$okImg) {
        echo "   ✗ Error al hacer UPDATE de Imagenes:\n";
        var_dump($stmtImg->errorInfo());
    } else {
        echo "   ✓ UPDATE Imagenes ejecutado\n";
        echo "   Filas afectadas: " . $stmtImg->rowCount() . "\n";

        // Si no actualizó ninguna fila, significa que NO existía registro de imagen
        if ($stmtImg->rowCount() === 0) {
            echo "   (i) No había registro previo de imagen. Insertando nuevo...\n";

            $sqlInsertImg = "INSERT INTO Imagenes (Nombre, Tipo, Id_Relacionado, EsPrincipal, Orden, FechaCreacion)
                             VALUES (?, 'Coleccion', ?, 1, 1, NOW())";

            $stmtInsert = $conn->prepare($sqlInsertImg);
            $okInsert = $stmtInsert->execute([$nombreFinal, $id]);

            if (!$okInsert) {
                echo "   ✗ Error al hacer INSERT en Imagenes:\n";
                var_dump($stmtInsert->errorInfo());
            } else {
                echo "   ✓ INSERT de nueva imagen correcto.\n";
            }
        }
    }

} else {
    echo "   (i) No se envió archivo en NuevaImagen. Solo se actualizan datos básicos.\n";
}

// 8) Mensaje final
echo "\n8) Todo el flujo terminó.\n";
echo "   Se debería haber actualizado la colección y, si se subió, la imagen.\n";

$_SESSION['Mensaje'] = "Colección actualizada correctamente (DEBUG).";
$_SESSION['TipoMensaje'] = "success";

// Mientras debugueas, deja comentado el redirect:
/// header("Location: index.php");
// exit;

echo "\nFIN DEBUG (no se hace redirect por ahora).\n";
echo "</pre>";
