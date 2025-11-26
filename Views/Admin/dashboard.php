<?php
$title = "Inicio - Minerva Streetwear";

require "../Layouts/header.php";
require "../Layouts/navbar.php";

// Llamamos los getters (IMPORTANTE: cada getter retorna la info)
$colecciones = include "../../Resources/Getters/getCollections.php";
$productos = include "../../Resources/Getters/getProductos.php";

?>
<div class="container py-5">
    <!-- HERO SECTION -->
    <section class="hero-section position-relative d-flex align-items-center justify-content-center text-center">
        <div class="hero-content text-white">
            <h1 class="display-3 fw-bold">Admin Panel</h1>
        </div>
    </section>



</div>

<?php require "../layouts/footer.php"; ?>