<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'publication_type_id' => 'required|exists:publication_types,id',
            'publication_category_id' => 'required|exists:publication_categories,id',
            'document_type_id' => 'required|exists:document_types,id',
            'author' => 'required',
            'summary' => 'required',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'publication_type_id' => '  Tipo de publicación',
            'publication_category_id' => 'La clasificación',
            'document_type_id' => 'El tipo de documento',
            'summary' => 'sumario',
            'description' => 'descripción',
            'media' => 'imagen',
        ];
    }
}
