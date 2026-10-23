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

    // Si todos los campos son válidos, convertimos los textos a números.
    // La coma se cambia por punto porque PHP solo entiende 2.5, no 2,5.
    if (empty($errores)) {
        $lados = [];
        foreach ($campos as $campo => $etiqueta) {
            $lados[$campo] = (float) str_replace(',', '.', $valores[$campo]);
        }

        // Solo en el triángulo: comprobamos que los tres lados formen un triángulo.
        if ($tipo === 'triangulo' && !esTrianguloValido($lados['lado1'], $lados['lado2'], $lados['lado3'])) {
            $errores['lado3'] = "Esos lados no forman un triángulo (la suma de dos lados debe ser mayor que el tercero).";
        }
    }

    // Si sigue sin haber errores, guardamos en la sesión y pasamos al resultado.
    if (empty($errores)) {
        $_SESSION['lados'] = $lados;
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
