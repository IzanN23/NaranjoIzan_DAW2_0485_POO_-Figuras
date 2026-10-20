<?php
// Carga la clase base que contiene tipo, primera medida y validación positiva.
require_once 'FiguraGeometrica.php';

// Triangulo hereda getters, setters y validaciones de FiguraGeometrica.
class Triangulo extends FiguraGeometrica
{
    // Las otras dos medidas son privadas y se leen mediante getters.
    private $lado2;
    private $lado3;

    public function __construct($lado1, $lado2, $lado3)
    {
        // El constructor padre valida y guarda el primer lado.
        parent::__construct("Triángulo", $lado1);
        $this->setLado2($lado2);
        $this->setLado3($lado3);

        // Validación geométrica: tres medidas positivas no siempre forman un triángulo.
        $a = $this->getLado1();
        $b = $this->getLado2();
        $c = $this->getLado3();
        if (!($a + $b > $c && $a + $c > $b && $b + $c > $a)) {
            throw new InvalidArgumentException("Los lados no forman un triángulo válido.");
        }
    }

    public function __destruct()
    {
        // No hay recursos especiales que liberar.
    }

    // Devuelve el segundo lado.
    public function getLado2()
    {
        return $this->lado2;
    }

    // El segundo lado debe cumplir la misma regla de positividad.
    public function setLado2($lado2)
    {
        $this->lado2 = $this->validarPositivo($lado2, "El lado 2");
    }

    // Devuelve el tercer lado.
    public function getLado3()
    {
        return $this->lado3;
    }

    // El tercer lado también se valida antes de guardarlo.
    public function setLado3($lado3)
    {
        $this->lado3 = $this->validarPositivo($lado3, "El lado 3");
    }

    // Fórmula de Herón: usa el semiperímetro para calcular el área sin altura.
    public function calcularArea()
    {
        $a = $this->getLado1();
        $b = $this->getLado2();
        $c = $this->getLado3();
        $s = ($a + $b + $c) / 2;
        return sqrt($s * ($s - $a) * ($s - $b) * ($s - $c));
    }

    public function calcularPerimetro()
    {
        // El perímetro es la suma de los tres lados.
        return $this->getLado1() + $this->getLado2() + $this->getLado3();
    }

    // PHP llama a este método cuando el objeto se usa como texto.
    public function __toString()
    {
        return $this->getTipoFigura() . " de lados " . $this->getLado1() . ", "
            . $this->getLado2() . " y " . $this->getLado3();
    }
}
