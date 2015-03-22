<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateDiskRequest extends Request {

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

            'diskSize' => 'required|unique:hard_disks,Disk_Size'
		];
	}

    public function messages()
    {
        return [
            'diskSize.required' => 'Cannot Update an empty Disk Size',
            'diskSize.unique' => 'Disk Size already Exist'

        ];
    }

}
