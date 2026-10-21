<?php
// Carga la sesión, la configuración y la función para dar formato a los resultados.
require_once 'includes/funciones.php';
// Carga las clases que representan cada figura concreta.
require_once 'clases/Triangulo.php';
require_once 'clases/Rectangulo.php';
require_once 'clases/Cuadrado.php';
require_once 'clases/Circulo.php';

$figuras = obtenerFiguras();

// El resultado solo tiene sentido si existen una figura y sus medidas en sesión.
if (!isset($_SESSION['tipoFigura']) || !isset($_SESSION['lados'])
    || !isset($figuras[$_SESSION['tipoFigura']])) {
    header("Location: index.php");
    exit;
}

$tipo = $_SESSION['tipoFigura'];
$lados = $_SESSION['lados'];
$figura = null;
$mensajeError = "";

// Creamos el objeto apropiado. Sus constructores vuelven a comprobar las medidas.
// Si alguna validación de la clase falla, se muestra el mensaje de la excepción.
try {
    switch ($tipo) {
        case 'triangulo':
            $figura = new Triangulo($lados['lado1'], $lados['lado2'], $lados['lado3']);
            break;
        case 'rectangulo':
            $figura = new Rectangulo($lados['lado1'], $lados['lado2']);
            break;
        case 'cuadrado':
            $figura = new Cuadrado($lados['lado1']);
            break;
        case 'circulo':
            $figura = new Circulo($lados['lado1']);
            break;
    }
} catch (Exception $e) {
    $mensajeError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="tarjeta">
        <h2>3. Resultado</h2>
        <!-- Si una clase rechazó los datos, no intentamos mostrar sus cálculos. -->
        <?php if ($figura === null): ?>
            <p class="error"><?= htmlspecialchars($mensajeError) ?></p>
        <?php else: ?>
            <!-- htmlspecialchars evita interpretar como HTML el texto mostrado. -->
            <table>
                <tr><th>Tipo de figura</th><td><?= htmlspecialchars($figura->getTipoFigura()) ?></td></tr>
                <tr><th>Descripción</th><td><?= htmlspecialchars((string) $figura) ?></td></tr>
                <tr><th>Área</th><td><?= formatear($figura->calcularArea()) ?></td></tr>
                <tr><th>Perímetro</th><td><?= formatear($figura->calcularPerimetro()) ?></td></tr>
            </table>
        <?php endif; ?>
        <!-- Permite volver al formulario conservando las medidas en sesión. -->
        <p><a class="boton" href="datos.php">&larr; Modificar medidas</a></p>
    </main>
</body>
</html>
