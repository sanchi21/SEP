<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateScreenRequest extends Request {

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

            'screenName' =>  'required|unique:screen_sizes,Screen_Size'
		];
	}

    public function messages()
    {
        return [
            'screenName.required' => 'Cannot Update an Empty Screen Size',
            'screenName.unique' => 'Screen Size already Exist'

        ];
    }

}
