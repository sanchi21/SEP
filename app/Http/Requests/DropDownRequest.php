<?php namespace App\Http\Requests;

use App\Column;
use App\Http\Requests\Request;
use App\Validation;
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
        $column = Input::get('table_column');
        $col = Column::where('table_column',$column)->first();
        $validation = Validation::find($col->validation);


        if($add_button != "" || $update_button != "")
        {
            if($col->validation != '0') {
                return [
                    'new_value' => 'required|' . $validation->validation
                ];
            }
            else
            {
                return [
                    'new_value' => 'required'
                ];
            }
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
