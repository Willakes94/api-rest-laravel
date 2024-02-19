<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{

    protected $table = 'terminais';

    use HasFactory;



    protected $fillable = [
        'nome',
        'empresa_id',
        'segmento',
        'endereco',
        'numero',
        'complemento',
        'cep',
        'bairro',
        'estado',
        'cidade',
        'telefone1',
        'telefone2',
        'periodo_funcionamento',
        'dias_semana',
        'fluxo_pessoas',
        'orientacao_terminal',
        'som_terminal',
        'ciclo_atualizacao',
        'fuso_horario',
        'status_terminal',
    ];

    public function rules()
    {
        return [
            'nome' => 'required|unique:terminais,nome,'.$this->id.'|min:3',
            'empresa_id' => 'required|integer|exists:empresas,id',
            'segmento' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'cep' => 'required|string|max:9', // 00000-000
            'bairro' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'telefone1' => 'nullable|string|max:15', // Supondo um formato (00) 00000-0000
            'telefone2' => 'nullable|string|max:15', // Supondo um formato (00) 00000-0000
            'periodo_funcionamento' => 'required|string|max:255',
            'dias_semana' => 'required|string|max:255', // Pode ser melhorado para validar dias específicos
            'fluxo_pessoas' => 'nullable|integer',
            'orientacao_terminal' => 'required|in:Horizontal,Vertical',
            'som_terminal' => 'sometimes|boolean',
            'ciclo_atualizacao' => 'required|date_format:d/m/Y',
            'fuso_horario' => 'required|string|max:255',
            'status_terminal' => 'required|string|max:255',
        ];
    }

    public function feedback()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'empresa_id.required' => 'É necessário selecionar uma empresa.',
            'empresa_id.exists' => 'A empresa selecionada não existe.',
            'segmento.required' => 'O campo segmento é obrigatório.',
            'endereco.required' => 'O campo endereço é obrigatório.',
            'numero.required' => 'O campo número é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'bairro.required' => 'O campo bairro é obrigatório.',
            'estado.required' => 'O campo estado é obrigatório.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'periodo_funcionamento.required' => 'O campo período de funcionamento é obrigatório.',
            'dias_semana.required' => 'O campo dias da semana é obrigatório.',
            'orientacao_terminal.required' => 'A orientação do terminal é obrigatória.',
            'orientacao_terminal.in' => 'A orientação do terminal deve ser Horizontal ou Vertical.',
            'som_terminal.boolean' => 'O valor do campo som do terminal deve ser verdadeiro ou falso.',
            'ciclo_atualizacao.required' => 'O campo ciclo de atualização é obrigatório.',
            'ciclo_atualizacao.date' => 'O ciclo de atualização deve ser uma data e hora válidas.',
            'fuso_horario.required' => 'O campo fuso horário é obrigatório.',
            'status_terminal.required' => 'O campo status do terminal é obrigatório.',

            // Validações de formato e tamanho
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.max' => 'O campo nome não deve exceder 255 caracteres.',
            'segmento.string' => 'O campo segmento deve ser um texto.',
            'segmento.max' => 'O campo segmento não deve exceder 255 caracteres.',
            'endereco.string' => 'O campo endereço deve ser um texto.',
            'endereco.max' => 'O campo endereço não deve exceder 255 caracteres.',
            'numero.string' => 'O campo número deve ser um texto.',
            'numero.max' => 'O campo número não deve exceder 255 caracteres.',
            'cep.string' => 'O campo CEP deve ser um texto.',
            'cep.max' => 'O campo CEP não deve exceder 9 caracteres.',
            'bairro.string' => 'O campo bairro deve ser um texto.',
            'bairro.max' => 'O campo bairro não deve exceder 255 caracteres.',
            'estado.string' => 'O campo estado deve ser um texto.',
            'estado.max' => 'O campo estado não deve exceder 255 caracteres.',
            'cidade.string' => 'O campo cidade deve ser um texto.',
            'cidade.max' => 'O campo cidade não deve exceder 255 caracteres.',
            'telefone1.string' => 'O campo telefone1 deve ser um texto.',
            'telefone1.max' => 'O campo telefone1 não deve exceder 15 caracteres.',
            'telefone2.string' => 'O campo telefone2 deve ser um texto.',
            'telefone2.max' => 'O campo telefone2 não deve exceder 15 caracteres.',
            'periodo_funcionamento.string' => 'O campo período de funcionamento deve ser um texto.',
            'periodo_funcionamento.max' => 'O campo período de funcionamento não deve exceder 255 caracteres.',
            'dias_semana.string' => 'O campo dias da semana deve ser um texto.',
            'dias_semana.max' => 'O campo dias da semana não deve exceder 255 caracteres.',
            'fuso_horario.string' => 'O campo fuso horário deve ser um texto.',
            'fuso_horario.max' => 'O campo fuso horário não deve exceder 255 caracteres.',
            'status_terminal.string' => 'O campo status do terminal deve ser um texto.',
            'status_terminal.max' => 'O campo status do terminal não deve exceder 255 caracteres.',

            // Validações nullable e tipos específicos
            'complemento.string' => 'O campo complemento deve ser um texto.',
            'complemento.max' => 'O campo complemento não deve exceder 255 caracteres.',
            'fluxo_pessoas.integer' => 'O campo fluxo de pessoas deve ser um número inteiro.',
        ];
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class); // Supõe que a chave estrangeira em `terminais` seja `empresa_id`
    }

    public function midias()
    {
        return $this->belongsTo(Midia::class);
    }


}
