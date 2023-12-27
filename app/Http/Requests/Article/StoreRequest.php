<?php

namespace App\Http\Requests\Article;

use App\Enum\ArticleTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['required',  Rule::in([ArticleTypeEnum::BLOG->value, ArticleTypeEnum::NEWS->value])],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachment' => ['required', 'file', 'mimes:jpg,png,svg,pdf'],
            'tags' => ['nullable', 'string']
        ];
    }
}
