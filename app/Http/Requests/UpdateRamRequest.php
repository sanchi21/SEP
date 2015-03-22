<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateRamRequest extends Request {

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

            'ramSize' => 'required|unique:rams,Ram_Size'

		];
	}

    public function messages()
    {
        return [
            'ramSize.required' => 'Cannot Update an Empty Ram size',
            'ramSize.unique' => 'Ram Size already Exist'

        ];
    }

}
