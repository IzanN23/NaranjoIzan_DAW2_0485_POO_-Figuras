<?php
// La clase intermedia reutiliza las medidas y la validación de FiguraGeometrica.
require_once 'FiguraGeometrica.php';

class Paralelogramo extends FiguraGeometrica
{
    // Son protected para que las clases hijas puedan heredarlos.
    protected $lado2;
    protected $altura;

    // tipoFigura y lado1 se inicializan en la clase padre.
    public function __construct($tipoFigura, $lado1, $lado2, $altura)
    {
        parent::__construct($tipoFigura, $lado1);
        $this->setLado2($lado2);
        $this->setAltura($altura);
    }

    public function __destruct()
    {
        // No hay recursos externos que liberar.
    }

    public function getLado2()
    {
        return $this->lado2;
    }

    public function setLado2($lado2)
    {
        $this->lado2 = $this->validarPositivo($lado2, "El lado 2");
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function setAltura($altura)
    {
        $this->altura = $this->validarPositivo($altura, "La altura");
    }

    // El área del paralelogramo se calcula multiplicando la base por la altura.
    public function calcularArea()
    {
        return $this->getLado1() * $this->getAltura();
    }

    // El perímetro suma dos veces la base y dos veces el lado inclinado.
    public function calcularPerimetro()
    {
        return 2 * ($this->getLado1() + $this->getLado2());
    }

    public function __toString()
    {
        return "Paralelogramo de base " . $this->getLado1() . " cm, lado "
            . $this->getLado2() . " cm y altura " . $this->getAltura() . " cm.";
    }
}
