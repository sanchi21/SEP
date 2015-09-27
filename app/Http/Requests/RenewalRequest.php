<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RenewalRequest extends Request {

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

            'req_upto' => 'required|date|after:chkDate',
        ];
    }

    public function messages()
    {
        return [
            'req_upto.required' => 'Date cannot be empty',
            'req_upto.date' => 'This should be a Date',
            'req_upto.after' => 'Should be a Date after Assigned Date',
        ];
    }

}



