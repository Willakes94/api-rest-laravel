<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use App\Http\Requests\StoreTerminalRequest;
use App\Http\Requests\UpdateTerminalRequest;
use App\Repositories\TerminalRepository;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    protected $terminal;

    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $terminalRepository = new TerminalRepository($this->terminal);

        if($request->has('atributos_empresa')){
            $atributos_empresa = 'empresa:id,'. $request->atributos_empresa;
            $atributos_empresa = $atributos_empresa;
            $terminalRepository->selectAtributosRegistrosRelacionados($atributos_empresa);

        } else {
            $terminalRepository->selectAtributosRegistrosRelacionados('empresa');
        }

        if($request->has('filtro')) {
            $terminalRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){

            $terminalRepository->selectAtributos($request->atributos);
        }



        return response()->json($terminalRepository->getResultado(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTerminalRequest $request)
    {
        // $terminal = Terminal::create($request->all());
        // nome
        // imagem

        $request->validate($this->terminal->rules(), $this->terminal->feedback());
        // stateless

        $terminal = $this->terminal->create($request->all());
        return response()->json($terminal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $terminal = $this->terminal->with(['empresa', 'midias'])->find($id);
        if ($terminal === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); // json
        }
        return response()->json($terminal, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Terminal $terminal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTerminalRequest $request, $id)
    {   /*
        print_r($request->all()); // dados atualizados
        echo '<hr>';
        print_r($terminal->getAttributes()); // dados antigos
        */

        // $terminal->update($request->all());
        $terminal = $this->terminal->find($id);
        if($terminal === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe!'], 404);
        }
        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($terminal->rules() as $input => $regra) {

                // coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $terminal->feedback());
        } else {
            $request->validate($terminal->rules(), $terminal->feedback());
        }

        $terminal->update($request->all());
        return response()->json($terminal, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        $terminal = $this->terminal->find($id);
        if ($terminal === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe!'], 404);
        }
        $terminal->delete();
        return response()->json(['msg' => 'O Terminal foi removido com sucesso!'], 200);
    }
}
