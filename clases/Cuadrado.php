<?php
// Carga la clase base, que proporciona la primera medida y su validación.
require_once 'FiguraGeometrica.php';

class Cuadrado extends FiguraGeometrica
{
    public function __construct($lado1)
    {
        // Un cuadrado solo necesita una medida: la longitud de su lado.
        parent::__construct("Cuadrado", $lado1);
    }

    public function __destruct()
    {
        // No hay recursos especiales que liberar.
    }

    // Área: lado multiplicado por lado.
    public function calcularArea()
    {
        return $this->getLado1() * $this->getLado1();
    }

    public function calcularPerimetro()
    {
        // Un cuadrado tiene cuatro lados iguales.
        return 4 * $this->getLado1();
    }

    // Texto descriptivo del objeto para la página de resultados.
    public function __toString()
    {
        return $this->getTipoFigura() . " de lado " . $this->getLado1();
    }
}
