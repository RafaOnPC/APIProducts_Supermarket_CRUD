<?php

namespace App\Http\Requests;


use App\Traits\MessageHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsRequest extends FormRequest
{
    use MessageHelper;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:200',
            'price' => 'required|numeric',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'description.required' => 'La descripcion es requerida',
            'price.required' => 'El precio es requerido', 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->jsend_fail($errors));
    }


}
