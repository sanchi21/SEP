<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMakeRequest extends Request {

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

            'make_name' => 'required|unique:makes,Make_Name',
		];
	}

    public function messages()
    {
        return [
            'make_name.required' => 'Please provide a Make Name',
            'make_name.unique' => 'Make already Exist'

        ];
    }

}
