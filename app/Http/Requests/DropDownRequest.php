<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;

class DropDownRequest extends Request {

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
        $add_button = Input::get('add_button');
        $update_button = Input::get('update_button');

        if($add_button != "" || $update_button != "")
        {
            return [
                'new_value' => 'required'
            ];
        }
        else
        {
            return [];
        }
	}

    public function messages()
    {
        return [
            'new_value.required' => 'Please provide a value',
        ];
    }

}
