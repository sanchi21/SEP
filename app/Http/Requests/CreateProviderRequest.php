<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateProviderRequest extends Request {

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

            'provider_name' => 'required|unique:service_providers,Provider_Name',
		];
	}

    public function messages()
    {
        return [
            'provider_name.required' => 'Please provide a Service Provider',
            'provider_name.unique' => 'Service Provider already Exist'

        ];
    }

}
