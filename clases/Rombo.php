<?php
// Rombo hereda los lados, la altura y el perímetro general de Paralelogramo.
require_once 'Paralelogramo.php';

class Rombo extends Paralelogramo
{
    // Las diagonales son datos propios del rombo y se mantienen privadas.
    private $diagonalMayor;
    private $diagonalMenor;

    // Recibe diagonales, calcula el lado y la altura, y pasa esas medidas a la clase padre.
    public function __construct($diagonalMayor, $diagonalMenor)
    {
        // Las diagonales forman cuatro triángulos rectángulos iguales.
        $lado = sqrt(pow($diagonalMayor / 2, 2) + pow($diagonalMenor / 2, 2));
        $altura = ($diagonalMayor * $diagonalMenor) / (2 * $lado);

        // En un rombo, base y lado tienen la misma longitud.
        parent::__construct("Rombo", $lado, $lado, $altura);
        $this->setDiagonalMayor($diagonalMayor);
        $this->setDiagonalMenor($diagonalMenor);
    }

    public function __destruct()
    {
        // No hay recursos externos que liberar.
    }


    public function getDiagonalMayor()
    {
        return $this->diagonalMayor;
    }

    public function setDiagonalMayor($diagonalMayor)
    {
        $this->diagonalMayor = $diagonalMayor;
    }

    public function getDiagonalMenor()
    {
        return $this->diagonalMenor;
    }

    public function setDiagonalMenor($diagonalMenor)
    {
        $this->diagonalMenor = $diagonalMenor;
    }
    
    // El área del rombo se calcula directamente con sus diagonales.
    public function calcularArea()
    {
        return ($this->getDiagonalMayor() * $this->getDiagonalMenor()) / 2;
    }

    // El perímetro de un rombo son cuatro lados iguales.
    public function calcularPerimetro()
    {
        return 4 * $this->getLado1();
    }

    public function __toString()
    {
        return "Rombo de diagonales " . $this->getDiagonalMayor() . " cm y "
            . $this->getDiagonalMenor() . " cm (lado " . $this->getLado1() . " cm).";
    }
}
