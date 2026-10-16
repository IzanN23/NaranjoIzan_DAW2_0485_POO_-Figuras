<?php
// Clase base común. Las clases de cada figura heredan de ella.
class FiguraGeometrica
{
    // private impide acceder directamente desde fuera de esta clase.
    private $tipoFigura;
    private $lado1;

    // El constructor inicializa la figura usando los setters.
    public function __construct($tipoFigura, $lado1)
    {
        $this->setTipoFigura($tipoFigura);
        $this->setLado1($lado1);
    }

    public function __destruct()
    {
        // No hay recursos especiales que liberar al destruir el objeto.
    }

    // Getter: permite leer el tipo sin exponer la propiedad directamente.
    public function getTipoFigura()
    {
        return $this->tipoFigura;
    }

    // Setter del tipo de figura.
    public function setTipoFigura($tipoFigura)
    {
        $this->tipoFigura = $tipoFigura;
    }

    // Getter para la primera medida (lado, base o radio según la figura).
    public function getLado1()
    {
        return $this->lado1;
    }

    // Setter que valida antes de guardar la primera medida.
    public function setLado1($lado1)
    {
        $this->lado1 = $this->validarPositivo($lado1, "El lado 1");
    }

    // Método protegido: la clase base y sus clases hijas pueden usarlo.
    // Si el dato no es numérico o no es positivo, lanza una excepción.
    protected function validarPositivo($valor, $nombre)
    {
        if (!is_numeric($valor) || $valor <= 0) {
            throw new InvalidArgumentException("$nombre debe ser un número mayor que 0.");
        }
        return (float) $valor;
    }

    // Método base que las clases hijas reemplazan con su fórmula específica.
    public function calcularArea()
    {
        return 0;
    }
}
