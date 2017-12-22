<?php

namespace NS\Support;

use NS\Support\Util\MapPath;

trait DadosEntrada
{
    public function set($campo, $valor)
    {
        if ($this->ehAninhado($campo)) {
            $this->setAninhado($campo, $valor);
        } else {
            if (array_key_exists($campo, $this->dadosEntrada)) {
                $this->dadosEntrada[$campo] = $valor;
            }
        }

        return $this;
    }

    private function setAninhado($campo, $valor)
    {
        $mapPath = new MapPath($this->dadosEntrada, '', '.');
        if ($mapPath->has($campo)) {
            $mapPath->set($valor, $campo);
        }
    }

    private function ehAninhado($valor)
    {
        return count(explode('.', $valor)) > 1;
    }
}