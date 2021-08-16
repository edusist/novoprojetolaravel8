<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidacaoFormulario extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer essa solicitação.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtenha as regras de validação que se aplicam à solicitação.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(2);

        $rules =  [
            'title' => [
                'required',
                'min:3',
                'max:60',
                //"unique:posts,title,{$id},id",
                Rule::unique('posts')->ignore($id)
            ],
            'content' => ['nullable', 'min:3', 'max:1000'],
            'image'   => ['required', 'image']
        ];

        if($this->method() == 'PUT') {

            $rules['image'] = ['nullable', 'image']; //Prenchimento opcional e se preecher o do tipo image

        }
        //dd($rules);
        return $rules;
    }
}// ['required', 'image|mimes:jpeg,png,jpg|max:1024']
