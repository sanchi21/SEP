<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class updateOSRequest extends Request {

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
            'osName' => 'required|unique:operating_systems,OS_Name'
		];
	}

    public function messages()
    {
        return [
            'osName.required' => 'Cannot Update an Empty Operating System',
            'osName.unique' => 'Operating System already Exist'

        ];
    }

}
