<?php
// Inicia o continúa la sesión para compartir la selección entre páginas.
session_start();

// Configuración central: define las figuras que la aplicación permite elegir
// y las medidas que se deben pedir para cada una.
function obtenerFiguras()
{
    return [
        'triangulo' => [
            'nombre' => 'Triángulo',
            'campos' => ['lado1' => 'Lado 1', 'lado2' => 'Lado 2', 'lado3' => 'Lado 3'],
        ],
        'rectangulo' => [
            'nombre' => 'Rectángulo',
            'campos' => ['lado1' => 'Base', 'lado2' => 'Altura'],
        ],
        'cuadrado' => [
            'nombre' => 'Cuadrado',
            'campos' => ['lado1' => 'Lado'],
        ],
        'circulo' => [
            'nombre' => 'Círculo',
            'campos' => ['lado1' => 'Radio'],
        ],
    ];
}

// Valida una medida recibida del formulario.
// Devuelve el mensaje de error; devuelve "" cuando el dato es válido.
function validarLado($valor, $nombre)
{
    // Permite introducir decimales usando coma o punto.
    $valor = str_replace(',', '.', trim($valor));

    // Rechaza valores vacíos antes de intentar convertirlos a número.
    if ($valor === '') {
        return "$nombre es obligatorio.";
    }
    // Acepta dígitos y, opcionalmente, decimales con punto.
    // Rechaza letras, signos negativos, varios puntos y formatos incompletos.
    if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $valor)) {
        return "$nombre debe ser un número positivo (sin letras ni signo negativo).";
    }
    // La expresión regular controla el formato; esta condición controla el valor.
    if ((float) $valor <= 0) {
        return "$nombre debe ser mayor que 0.";
    }
    return "";
}

function esTrianguloValido($a, $b, $c)
{
    // La suma de cualquier pareja de lados debe ser mayor que el tercer lado.
    return ($a + $b > $c && $a + $c > $b && $b + $c > $a);
}

// Convierte un número a texto con dos decimales y coma decimal.
function formatear($numero)
{
    return number_format($numero, 2, ',', '.');
}
