<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Midia;
use App\Http\Requests\StoreMidiaRequest;
use App\Http\Requests\UpdateMidiaRequest;
use App\Repositories\MidiaRepository;
use Illuminate\Http\Request;

class MidiaController extends Controller
{

    protected $midia;

    public function __construct(Midia $midia)
    {
        $this->midia = $midia;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $midiaRepository = new MidiaRepository($this->midia);

        if($request->has('atributos_empresa')){
            $atributosEmpresa = 'empresa:id,' . $request->atributos_empresa;
            $midiaRepository->selectAtributosRegistrosRelacionados([$atributosEmpresa]);
        }

        if($request->has('atributos_terminal')){
            $atributosTerminal = 'terminal:id,' . $request->atributos_terminal;
            // Supondo que seu método selectAtributosRegistrosRelacionados possa aceitar múltiplos relacionamentos
            $midiaRepository->selectAtributosRegistrosRelacionados([$atributosEmpresa, $atributosTerminal]);
        }

        else {
            $midiaRepository->selectAtributosRegistrosRelacionados(['empresa', 'terminal']);
        }

        if($request->has('filtro')) {
            $midiaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){

            $midiaRepository->selectAtributos($request->atributos);
        }



        return response()->json($midiaRepository->getResultado(), 200);



        // -----------------------------------------------------
        // $midia = Midia::all();


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
    public function store(StoreMidiaRequest $request)
    {
        //$midia = Midia::create($request->all());
        //nome
        //imagem

        $request->validate($this->midia->rules(), $this->midia->feedback());
        // stateless

        //dd($request->nome);
        //dd($request->get('nome'));
        //dd($request->input('nome'));


        //dd($request->hasFile('path_imagem'));
        //dd($request->hasFile('path_video'));

        //dd($request->file('path_imagem'));
        //dd($request->file('path_video'));

        $imagem = $request->file('path_imagem');
        $imagem_urn = $imagem->store('imagens', 'public');
        $video = $request->file('path_video');
        $video_urn = $video->store('videos', 'public');



        $midia = $this->midia->create([
            'nome' => $request->nome,
            'empresa_id' => $request->empresa_id,
            'terminal_id' => $request->terminal_id,
            'categoria' => $request->categoria,
            'path_imagem' => $imagem_urn,
            'path_video' => $video_urn,
            'orientacao' => $request->orientacao,
            'horario_inicio_exibicao' => $request->horario_inicio_exibicao,
            'horario_fim_exibicao' => $request->horario_fim_exibicao
        ]);

        /*

        $midia->nome = $request->nome;
        $midia->imagem = $imagem_urn;
        $midia->video = $video_urn;

        */






        return response()->json($midia, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $midia = $this->midia->with(['empresa', 'terminais'])->find($id);
        if ($midia === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe.'], 404); //json
        }
        return response()->json($midia, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Midia $midia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMidiaRequest $request, $id)
    {  /*
        print_r($request->all()); //dados atulizados
        echo '<hr>';
        print_r($midia->getAttributes()); // dados antigos
        */

        // $midia->update($request->all());
        $midia = $this->midia->find($id);

        //dd($request->nome);
        //dd($request->file('path_imagem'));

        if ($midia === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe!'], 404);
        }
        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            // percorrendo todas as regras definidas no Model
            foreach ($midia->rules() as $input => $regra) {

                // coletar apenas as regras aplicaveis aos parametros parciais da requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }


            $request->validate($regrasDinamicas, $midia->feedback());
        } else {
            $request->validate($midia->rules(), $midia->feedback());
        }

        // remove o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if ($request->file('path_imagem')) {
            Storage::disk('public')->delete($midia->path_imagem);
        }

        if ($request->file('path_video')) {
            Storage::disk('public')->delete($midia->path_video);
        }

        $imagem = $request->file('path_imagem');
        $imagem_urn = $imagem->store('imagens', 'public');
        $video = $request->file('path_video');
        $video_urn = $video->store('videos', 'public');

        $midia->fill($request->all());
        $midia->path_imagem = $imagem_urn;
        $midia->save();
        /*
        $midia->update([
            'nome' => $request->nome,
            'empresa_id' => $request->empresa_id,
            'terminal_id' => $request->terminal_id,
            'categoria' => $request->categoria,
            'path_imagem' => $imagem_urn,
            'path_video' => $video_urn,
            'orientacao' => $request->orientacao,
            'horario_inicio_exibicao' => $request->horario_inicio_exibicao,
            'horario_fim_exibicao' => $request->horario_fim_exibicao
        ]);

        */
        return response()->json($midia, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        $midia = $this->midia->find($id);

        if ($midia === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe!'], 404);
        }

        //remove o arquivo antigo imagem/video
        Storage::disk('public')->delete($midia->path_imagem);
        Storage::disk('public')->delete($midia->path_video);


        $midia->delete();
        return response()->json(['msg' => 'A Midia foi removida com sucesso!'], 200);
    }
}
