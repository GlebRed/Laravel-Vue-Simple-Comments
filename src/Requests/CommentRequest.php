<?php

namespace GlebRed\LaravelVueSimpleComments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'commentable_id' => ['required', 'integer'],
            'commentable_type' => ['required', 'string'],
            //check types
            //'commentable_type' => ['required', 'string', 'in:materials,news,answers,discussions'],
            'body' => ['required'],
        ];
    }
}
