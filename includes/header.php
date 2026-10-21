<!-- Cabecera reutilizable en las pantallas de medidas y resultado. -->
<header class="cabecera">
    <h1>Figuras geométricas</h1>
    <!-- $figuras y $tipo se preparan en la página que incluye este archivo. -->
    <!-- htmlspecialchars muestra el nombre como texto, no como código HTML. -->
    <p>Figura seleccionada: <strong><?= htmlspecialchars($figuras[$tipo]['nombre']) ?></strong>
       &middot; <a href="index.php">Cambiar figura</a></p>
</header>
