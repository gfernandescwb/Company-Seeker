<?php

namespace App\Http\Requests\API\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'integer|required',
            'name' => 'string|required',
            'cep' => 'integer|required',
            'logo' => 'image|nullable',
            'address' => 'string|required',
            'city' => 'string|required',
            'state' => 'string|required',
            'number' => 'string|required',
            'complement' => 'string|nullable'
        ];
    }
}
