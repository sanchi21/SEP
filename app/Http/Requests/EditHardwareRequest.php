<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Column;
use App\Validation;
use Illuminate\Support\Facades\Input;

class EditHardwareRequest extends Request {

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
        if(Input::get('update') != '')
        {
            $columns = Column::select('table_column','column_name','validation','cid')->where('validation','>',0)->groupBy('table_column')->orderBy('cid')->get();
            $rules = [];

            foreach ($columns as $col) {
                $validation = Validation::find($col->validation);
                $a = $col->table_column;
                $b = $validation->validation;
                $rules[$a] = $b;
            }

            return $rules;
        }
        else
            return [];
    }

//    public function messages()
//    {
//        $messages =[];
//        $columns = Column::select('table_column','column_name','validation','cid')->where('validation','not null')->groupBy('table_column')->orderBy('cid')->get();
//
//        foreach ($columns as $col)
//        {
//            $validation = Validation::find($col->validation);
//            $attr = $col->table_name;
//            $valid = $validation->validation;
//            $t = $attr.'.'.$valid;
//            $msg = $attr.": ".$validation->message;
//
//            $messages = [$t => $msg];
//        }
//
//        return $messages;
//    }

}
