<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanStoreRequest extends FormRequest
{
    public function authorize()
    {
        // permitir a cualquier usuario (puedes restringir con auth middleware en el futuro)
        return true;
    }

    public function rules()
    {
        return [
            'provincia' => ['required', 'string', Rule::exists('municipios', 'provincia')],
            'municipio' => ['required', 'string', Rule::exists('municipios', 'municipio')],
            'start_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'items' => ['sometimes', 'string'], // JSON string optional
        ];
    }

    public function messages()
    {
        return [
            'provincia.required' => 'Selecciona una provincia.',
            'provincia.exists' => 'La provincia seleccionada no es válida.',
            'municipio.required' => 'Selecciona un municipio.',
            'municipio.exists' => 'El municipio seleccionado no es válido.',
            'start_date.required' => 'Indica la fecha de inicio.',
            'start_date.date_format' => 'Formato de fecha de inicio inválido (YYYY-MM-DD).',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'end_date.required' => 'Indica la fecha de fin.',
            'end_date.date_format' => 'Formato de fecha de fin inválido (YYYY-MM-DD).',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    }
}
