<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateDiskRequest extends Request {

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

            'disk_size' => 'required|unique:hard_disks,Disk_Size',
		];
	}

    public function messages()
    {
        return [
            'disk_size.required' => 'Please provide a Disk Size',
            'disk_size.unique' => 'Disk Size already Exist'

        ];
    }


}
