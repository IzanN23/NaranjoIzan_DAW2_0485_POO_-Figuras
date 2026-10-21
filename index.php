<?php
// Carga las funciones comunes. Este archivo también inicia la sesión.
require_once 'includes/funciones.php';

// Obtiene las figuras permitidas y sus campos desde una sola fuente.
$figuras = obtenerFiguras();
$error = "";
// Si ya se eligió una figura antes, se marca como seleccionada.
$seleccionada = $_SESSION['tipoFigura'] ?? "";

// El formulario usa POST cuando el usuario pulsa «Continuar».
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // El operador ?? evita avisos si el campo no llegó en la petición.
    $tipo = $_POST['tipoFigura'] ?? "";

    // No confiamos solo en las opciones que muestra el HTML:
    // el cliente podría enviar manualmente un valor distinto.
    if (!array_key_exists($tipo, $figuras)) {
        $error = "Debes elegir una figura de la lista.";
        $seleccionada = "";
    } else {
        // Si cambia de figura, las medidas de la anterior ya no sirven.
        if ($tipo !== ($_SESSION['tipoFigura'] ?? "")) {
            unset($_SESSION['lados']);
        }
        // La sesión conserva la selección entre páginas.
        $_SESSION['tipoFigura'] = $tipo;
        // El patrón POST/Redirect/GET evita reenviar el formulario al recargar.
        header("Location: datos.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elegir figura</title>
    <!-- Hoja de estilos compartida por las páginas del proyecto. -->
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header class="cabecera"><h1>Figuras geométricas</h1></header>
    <main class="tarjeta">
        <h2>1. Elige una figura</h2>
        <!-- novalidate deja que validaciones.js controle el mensaje del formulario. -->
        <form id="formFigura" method="post" action="index.php" novalidate>
            <label for="tipoFigura">Tipo de figura</label>
            <select id="tipoFigura" name="tipoFigura">
                <option value="">-- Selecciona --</option>
                <!-- Las opciones se generan desde la lista permitida en PHP. -->
                <?php foreach ($figuras as $clave => $figura): ?>
                    <option value="<?= $clave ?>" <?= $seleccionada === $clave ? 'selected' : '' ?>>
                        <?= $figura['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="error" id="error-tipoFigura"><?= htmlspecialchars($error) ?></span>
            <button type="submit">Continuar</button>
        </form>
    </main>
    <!-- Esta validación mejora la experiencia, pero PHP vuelve a validar los datos. -->
    <script src="js/validaciones.js"></script>
</body>
</html>
