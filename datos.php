<?php
// Carga la configuración de figuras y las funciones de validación.
require_once 'includes/funciones.php';

$figuras = obtenerFiguras();

// Protege esta página: el usuario debe haber elegido una figura válida primero.
if (!isset($_SESSION['tipoFigura']) || !isset($figuras[$_SESSION['tipoFigura']])) {
    header("Location: index.php");
    exit;
}

// La configuración determina cuántas medidas hay y cómo se llaman.
$tipo = $_SESSION['tipoFigura'];
$campos = $figuras[$tipo]['campos'];
// $errores guardará un mensaje por cada campo incorrecto.
$errores = [];
$valores = [];

// Recupera medidas anteriores para que el formulario no se vacíe al volver atrás.
foreach ($campos as $campo => $etiqueta) {
    $valores[$campo] = $_SESSION['lados'][$campo] ?? "";
}

// Las validaciones del servidor se ejecutan al recibir el formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($campos as $campo => $etiqueta) {
        // trim elimina espacios al principio y al final.
        $valores[$campo] = trim($_POST[$campo] ?? "");
        // validarLado devuelve una cadena vacía si el valor es válido.
        $mensaje = validarLado($valores[$campo], $etiqueta);
        if ($mensaje !== "") {
            $errores[$campo] = $mensaje;
        }
    }

    // Además de ser positivos, los tres lados deben poder formar un triángulo.
    if (empty($errores) && $tipo === 'triangulo') {
        // Convertimos la coma decimal a punto y después a número decimal.
        $a = (float) str_replace(',', '.', $valores['lado1']);
        $b = (float) str_replace(',', '.', $valores['lado2']);
        $c = (float) str_replace(',', '.', $valores['lado3']);
        if (!esTrianguloValido($a, $b, $c)) {
            $errores['lado3'] = "Esos lados no forman un triángulo (la suma de dos lados debe ser mayor que el tercero).";
        }
    }

    if (empty($errores)) {
        $lados = [];
        // Guardamos números, no texto, para que las clases puedan calcular con ellos.
        foreach ($campos as $campo => $etiqueta) {
            $lados[$campo] = (float) str_replace(',', '.', $valores[$campo]);
        }
        $_SESSION['lados'] = $lados;
        // Solo se avanza si todas las validaciones del servidor han pasado.
        header("Location: resultado.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Introducir medidas</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="tarjeta">
        <h2>2. Introduce las medidas</h2>
        <!-- novalidate permite mostrar los mensajes personalizados bajo cada campo. -->
        <form id="formLados" method="post" action="datos.php" novalidate>
            <?php foreach ($campos as $campo => $etiqueta): ?>
                <label for="<?= $campo ?>"><?= $etiqueta ?></label>
                <!-- Es text para aceptar coma decimal; inputmode sugiere teclado numérico. -->
                <input type="text" id="<?= $campo ?>" name="<?= $campo ?>"
                       data-nombre="<?= $etiqueta ?>" inputmode="decimal"
                       value="<?= htmlspecialchars($valores[$campo]) ?>"
                       class="<?= isset($errores[$campo]) ? 'input-error' : '' ?>">
                <!-- PHP conserva el error si el servidor rechaza el valor. -->
                <span class="error" id="error-<?= $campo ?>"><?= htmlspecialchars($errores[$campo] ?? "") ?></span>
            <?php endforeach; ?>
            <button type="submit">Calcular</button>
        </form>
    </main>
    <!-- JavaScript valida al instante; PHP hace la validación definitiva. -->
    <script src="js/validaciones.js"></script>
</body>
</html>
