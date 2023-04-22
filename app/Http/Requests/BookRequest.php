<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidateISBNRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'genreIdentifier' => ['required', 'integer', 'exists:App\Models\Genre,uniqueGenreId'],
            'publisherIdentifier' => ['required', 'integer', 'exists:App\Models\Publisher,uniquePublisherId'],
            'authorIdentifier' => [
                'required',
                'integer',
                Rule::exists('users', 'uniqueUserId')->where(function ($query) {
                    $query->where('role', User::ROLES['author']);
                }),
            ],
            'description' => ['required', 'string'],
            'isbn' => ['required', new ValidateISBNRule],
        ];

        if ($this->method() == 'PUT') {
            $rules['bookIdentifier'] = ['required', 'integer', 'exists:App\Models\Book,uniqueBookId'];
        }

        return $rules;

    }
}
