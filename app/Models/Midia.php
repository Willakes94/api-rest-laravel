<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'empresa_id',
        'terminal_id',
        'categoria',
        'path_imagem',
        'path_video',
        'orientacao',
        'horario_inicio_exibicao',
        'horario_fim_exibicao'
    ];

    public function rules()
    {
        return [
            'nome' => 'required|unique:midias,nome,' . $this->id . '|min:3',
            'empresa_id' => 'required|exists:empresas,id',
            'terminal_id' => 'required|exists:terminais,id',
            'categoria' => 'required|string|max:255',
            'path_imagem' => 'nullable|file|image|max:2048',
            'path_video' => 'nullable|file|mimes:mp4|max:1000000',
            'orientacao' => 'required|in:Horizontal,Vertical',
            'horario_inicio_exibicao' => 'nullable|date_format:H:i',
            'horario_fim_exibicao' => 'nullable|date_format:H:i'
        ];
    }


    public function feedback()
    {
        return  [
            'nome.required' => 'O campo nome é obrigatório.',
            'empresa_id.required' => 'O campo empresa é obrigatório.',
            'empresa_id.exists' => 'A empresa selecionada não existe.',
            'terminal_id.required' => 'O campo terminal é obrigatório.',
            'terminal_id.exists' => 'O terminal selecionado não existe.',
            'categoria.required' => 'O campo categoria é obrigatório.',
            'path_imagem.image' => 'O arquivo de imagem não é válido.',
            'path_imagem.max' => 'O arquivo de imagem deve ter no máximo :max kilobytes.',
            'path_video.mimes' => 'O vídeo deve ser um arquivo do tipo: :values.',
            'path_video.max' => 'O arquivo de vídeo deve ter no máximo :max kilobytes.',
            'orientacao.required' => 'A orientação é obrigatória.',
            'orientacao.in' => 'A orientação deve ser Horizontal ou Vertical.',
            'horario_inicio_exibicao.date_format' => 'O horário de início de exibição deve ser uma hora válida no formato HH:mm.',
            'horario_fim_exibicao.date_format' => 'O horário de fim de exibição deve ser uma hora válida no formato HH:mm.',
        ];
    }



    public function empresa()
    {

        return $this->belongsTo(Empresa::class); // ou 'App\Models\Empresa'
    }


    public function terminal() {
        return $this->belongsTo(Terminal::class);
    }
}
