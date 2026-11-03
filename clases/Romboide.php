<?php
// Romboide hereda las medidas, los cálculos y la descripción genérica del paralelogramo.
require_once 'Paralelogramo.php';

class Romboide extends Paralelogramo
{
    // Recibe base, lado inclinado y altura, y establece el tipo concreto.
    public function __construct($base, $lado, $altura)
    {
        parent::__construct("Romboide", $base, $lado, $altura);
    }

    public function __destruct()
    {
        // No hay recursos externos que liberar.
    }

    public function __toString()
    {
        return "Romboide de base " . $this->getLado1() . " cm, lado "
            . $this->getLado2() . " cm y altura " . $this->getAltura() . " cm.";
    }
}
