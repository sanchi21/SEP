<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateOSRequest extends Request {

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

            'os_name' => 'required|unique:operating_systems,OS_Name',

		];
	}

    public function messages()
    {
        return [
            'os_name.required' => 'Please provide an Operating System Name',
            'os_name.unique' => 'Operating System already Exist'

        ];
    }

}
