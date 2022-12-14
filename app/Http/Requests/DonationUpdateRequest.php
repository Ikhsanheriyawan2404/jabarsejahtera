<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'total_budget' => 'required',
            'description' => 'required',
            'category' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:2058',
        ];
    }
}
