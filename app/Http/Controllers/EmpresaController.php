<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Repositories\EmpresaRepository;

class EmpresaController extends Controller
{
    protected $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresaRepository = new EmpresaRepository ($this->empresa);

        if($request->has('atributos_terminais')){
            $atributos_terminais = 'terminais:id,'. $request->atributos_terminais;
            $atributos_terminais = $atributos_terminais;
            $empresaRepository->selectAtributosRegistrosRelacionados($atributos_terminais);

        } else {
            $empresaRepository->selectAtributosRegistrosRelacionados('terminais');
        }

        if($request->has('filtro')) {
            $empresaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){

            $empresaRepository->selectAtributos($request->atributos);
        }



        return response()->json($empresaRepository->getResultado(), 200);
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
    public function store(StoreEmpresaRequest $request)
    {
        //$empresa = Empresa::create($request->all());
        //nome
        //imagem




        $request->validate($this->empresa->rules(), $this->empresa->feedback());
        // stateless

        $empresa = $this->empresa->create($request->all());
        return response()->json($empresa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $empresa = $this->empresa->with('terminais')->find($id);
        if ($empresa === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); //json
        }
        return response()->json($empresa, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, $id)
    {   /*
        print_r($request->all()); //dados atualizado
        echo '<hr>';
        print_r($empresa->getAttributes()); // dados antigos
        */

        // $empresa->update($request->all());
        $empresa = $this->empresa->find($id);
        if ($empresa === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe!'], 404);
        }
        if ($request->method() === 'PATCH') {



            $regrasDinamicas = array();

            // percorrendo todas as regras definidas no MOdel
            foreach ($empresa->rules() as $input => $regra) {


                // coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }



            $request->validate($regrasDinamicas, $empresa->feedback());
        } else {
            $request->validate($empresa->rules(), $empresa->feedback());
        }



        $empresa->update($request->all());
        return response()->json($empresa, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empresa = $this->empresa->find($id);
        if ($empresa === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe!'], 404);
        }
        $empresa->delete();
        return response()->json(['msg' => 'A empresa foi removida com sucesso!'], 200);
    }
}
