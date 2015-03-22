<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateMakeRequest extends Request {

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

            'makeName' => 'required|unique:makes,Make_Name'
		];
	}

    public function messages()
    {
        return [
            'makeName.required' => 'Cannot Update an Empty Make',
            'makeName.unique' => 'Make already Exist'

        ];
    }


}
