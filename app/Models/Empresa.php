<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
    'nome',
    'nome_fantasia',
    'tipo_empresa',
    'apelido',
    'cpf_cnpj',
    'endereco',
    'numero',
    'complemento',
    'cep',
    'bairro',
    'estado',
    'cidade',
    'email',
    'telefone1',
    'telefone2'
    ];

    public function rules(){
        return [
            'nome' => 'required|unique:empresas,nome,'.$this->id.'|min:3',
            'nome_fantasia' => 'required',
            'tipo_empresa' => 'required',
            'apelido',
            'cpf_cnpj' => 'required|unique:empresas',
            'endereco' => 'required',
            'numero' => 'required',
            'complemento',
            'cep' => 'required',
            'bairro' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'email' => 'required|unique:empresas',
            'telefone1' => 'required',
            'telefone2'
        ];

        /*
            1) tabela
            2) nome da coluna que será pesquisada
            3) id do registro que será desconsiderado na pesquisa
        */
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obritório',
            'nome.unique' => 'O nome já existe.',
            'cpf_cnpj.unique' => 'O campo :attribute já existe.',
            'email.unique' => 'O campo :attribute já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.'
        ];
    }


    public function terminais()
    {
        return $this->hasMany(Terminal::class); // Supõe que a chave estrangeira em `terminais` seja `empresa_id`
    }
}
