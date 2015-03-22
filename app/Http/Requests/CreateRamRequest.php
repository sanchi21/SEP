<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateRamRequest extends Request {

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

            'ram_size' => 'required|unique:rams,Ram_Size',
		];
	}


    public function messages()
    {
        return [
            'ram_size.required' => 'Please provide a Ram Size',
            'ram_size.unique' => 'Ram Size already Exist'

        ];
    }

}
