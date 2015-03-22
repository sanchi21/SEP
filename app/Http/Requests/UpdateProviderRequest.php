<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateProviderRequest extends Request {

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

            'ProviderName' => 'required|unique:service_providers,Provider_Name',
		];
	}

    public function messages()
    {
        return [
            'ProviderName.required' => 'Cannot Update an Empty Service Provider',
            'ProviderName.unique' => 'Service Provider already Exist'

        ];
    }

}
