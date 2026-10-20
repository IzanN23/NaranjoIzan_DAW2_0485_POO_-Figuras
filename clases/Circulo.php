<?php
// Carga la clase base, que proporciona la medida y su validación.
require_once 'FiguraGeometrica.php';

class Circulo extends FiguraGeometrica
{
    // En esta clase, la propiedad heredada lado1 representa el radio.
    public function __construct($lado1)
    {
        // El constructor padre guarda el tipo y valida que el radio sea positivo.
        parent::__construct("Círculo", $lado1);
    }

    public function __destruct()
    {
        // No hay recursos especiales que liberar.
    }

    // Área del círculo: pi multiplicado por el radio al cuadrado.
    public function calcularArea()
    {
        return pi() * $this->getLado1() * $this->getLado1();
    }

    public function calcularPerimetro()
    {
        // Longitud de la circunferencia: dos por pi por el radio.
        return 2 * pi() * $this->getLado1();
    }

    // Texto descriptivo del objeto para la página de resultados.
    public function __toString()
    {
        return $this->getTipoFigura() . " de radio " . $this->getLado1();
    }
}
