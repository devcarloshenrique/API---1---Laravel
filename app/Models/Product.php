<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    // Regras de validação
    public function rules($id = '')
    {
        return [
            /**
             * O campo name só poder ser igual ao name do usuario correspondente ao
             * id do usuario que  foi passado como parametro.
             */
            'name'        => "required|min:3|max:100|unique:products,name,{$id},id",
            'description' => 'required|min:3|max:100'
        ];
    }

    public function rulesSearch()
    {
        return [
            'key-search' => 'required',
        ];
    }

    public function search($data, $totalPage)
    {
        return $this
            /**
             * orWhere para pesquisar pelo name ou pela descrição, LIKE é pesquisa SQL
             */
            ->where('name', $data['key-search'])
            ->orWhere('description', 'LIKE', "% {$data['key-search']}%")
            ->paginate($totalPage);
    }
}
