<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateSoftwareRequest extends Request {

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
			'name_t' => 'required|unique:software,name|alpha_num',

		];
	}

    public function messages()
    {
        return [
            'name_t.required' => 'Name is Required',
            'name_t.unique' => 'Name already exist',
            'name_t.alpha_num' => 'Name should contain only alpha numeric'

        ];
    }

}
