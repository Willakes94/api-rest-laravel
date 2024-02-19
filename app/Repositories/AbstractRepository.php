<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository{

    protected $terminal;

    public function __construct(Model $terminal)
    {
        $this->terminal = $terminal;
    }

    public function selectAtributosRegistrosRelacionados($atributos)
    {

        $this->terminal = $this->terminal->with($atributos);
        // a query está sendo montada (mater sempre atualizada)
    }

    public function filtro($filtros)
    {
        $filtros = explode(';', $filtros);
        foreach ($filtros as $key => $condicao) {
            $c = explode(':', $condicao);
            $this->terminal = $this->terminal->where($c[0], $c[1], $c[2]);
        }
    }


    public function selectAtributos($atributos)
    {
        $this->terminal = $this->terminal->selectRaw($atributos);
    }

    public function getResultado()
    {
        return $this->terminal->get();
    }
}

?>
