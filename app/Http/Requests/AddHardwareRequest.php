<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddHardwareRequest extends Request {

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
//		$rules = [
//            'quan' => 'required|min:5',
//		];
//
//        foreach($this->request->get('description') as $key => $val)
//        {
//            $rules['description at row '.($key+1)] = 'required';
//        }
//
//        return $rules;
	}

}
