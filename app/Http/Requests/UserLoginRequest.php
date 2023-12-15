<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => "Required"
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->extractNumbers($this->input("phone"))
        ]);
    }

    private function extractNumbers(string $phone): string
    {
        $coll = str_split($phone);
        $filtered = array_filter($coll, fn($item) => is_numeric($item));
        return implode("", $filtered);
    }
}
