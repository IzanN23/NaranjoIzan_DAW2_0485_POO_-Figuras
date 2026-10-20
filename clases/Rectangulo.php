<?php
// Carga la clase base y reutiliza su validación de medidas positivas.
require_once 'FiguraGeometrica.php';

class Rectangulo extends FiguraGeometrica
{
    // El primer lado se hereda; el segundo se declara en esta clase.
    private $lado2;

    public function __construct($lado1, $lado2)
    {
        // El padre guarda el tipo y valida la primera medida.
        parent::__construct("Rectángulo", $lado1);
        // El setter valida y guarda la segunda medida.
        $this->setLado2($lado2);
    }

    public function __destruct()
    {
        // No hay recursos especiales que liberar.
    }

    // Getter para mantener privada la propiedad lado2.
    public function getLado2()
    {
        return $this->lado2;
    }

    public function setLado2($lado2)
    {
        // Reutiliza el método protegido heredado para exigir un valor positivo.
        $this->lado2 = $this->validarPositivo($lado2, "El lado 2");
    }

    // Área del rectángulo: base por altura.
    public function calcularArea()
    {
        return $this->getLado1() * $this->getLado2();
    }

    public function calcularPerimetro()
    {
        // Dos veces la suma de la base y la altura.
        return 2 * ($this->getLado1() + $this->getLado2());
    }

    // Representación legible para mostrar en el resultado.
    public function __toString()
    {
        return $this->getTipoFigura() . " de base " . $this->getLado1()
            . " y altura " . $this->getLado2();
    }
}
