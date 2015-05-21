<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddDepreciateRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'inventory_code_dep' => 'unique:depreciations,inventory_code',
            'residual' => 'required_if:method,Straight Line',
            'year' => 'required_if:method,Straight Line|digits_between:1,100',
            'percentage' => 'required_if:method,Declining|digits_between:1,100',
		];
	}

}
