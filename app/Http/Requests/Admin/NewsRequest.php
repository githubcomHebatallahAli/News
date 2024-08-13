<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class NewsRequest extends FormRequest
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

            'title' =>'nullable|string',
            'description' =>'nullable|string',
            'writer' =>'nullable|string',
            'event_date' => 'nullable|date_format:Y-m-d H:i:s',
            'url' =>'string|nullable',
            'img.*'=>'nullable|image|mimes:jpg,jpeg,png,gif,svg',
            'videoUrl' => 'nullable|url',
            'videoLabel' => 'nullable|string',
            'part1'=>'nullable|string',
            'part1'=>'nullable|string',
            'part1'=>'nullable|string',
            'status' => 'nullable|string',
            'adsenseCode' => 'nullable|string',
            'keyWords' => 'nullable|array',
            'keyWords.*' => 'string|nullable',
             'category_id'=>'nullable|exists:categories,id',
            //  'suggested_news_ids' => 'nullable|array',
            //  'suggested_news_ids.*' => 'nullable|exists:news,id',
            'suggested_news_ids' => 'nullable|string',

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
