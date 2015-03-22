<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateScreenRequest extends Request {

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


            'screen_size' => 'required|unique:screen_sizes,Screen_Size',


		];
	}

    public function messages()
    {
        return [
            'screen_size.required' => 'Please provide a Screen Size',
            'screen_size.unique' => 'Screen size already Exist'

        ];
    }

}
