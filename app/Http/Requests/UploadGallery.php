<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadGallery extends FormRequest
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
        $rules = [
            'id' => 'required'
        ];
        $req[] = $this->input('photos');
        $photos = count($req);
        foreach(range(0, $photos) as $index) {
            $rules['photos.' . $index] = 'required|image|max:2000';
        }

        return $rules;

        return [
            //
        ];
    }
}
