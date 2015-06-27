<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChangeColumnRequest extends Request {

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
//        $col = Column::find('124');
//        $c = $col->table_column;
//        $valid = $col->validation;

		return [
            'inv' => 'required_if:category,/change-property/New|unique:types,key|regex:/^([A-Za-z]{3})\/([A-Z]{3})$/',
            'new_category' => 'required_if:category,/change-property/New|unique:types,category|alpha_dash',
            'existing_attribute' => 'required_if:attribute_name,null',
		];
	}
    public function messages()
    {
        return [
            'inv.required_if' => 'Please provide Inventory Code Pattern',
            'inv.unique' => 'Inventory Code Pattern Already Exist',
            'inv.regex' => 'Inventory Code Pattern Should be of XXX/XXX Pattern',
            'new_category.unique' => 'Category Already Exist',
            'new_category.required_if' => 'Please Provide New Category a Name',

        ];
    }

}
