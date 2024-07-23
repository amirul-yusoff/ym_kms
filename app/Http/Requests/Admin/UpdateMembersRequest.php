<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UpdateMembersRequest extends FormRequest
{
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
            'employee_code' => 'required|unique:members,employee_code,'.$this->route('member')->id,
            'employee_name' => 'required',
            'image' =>'image|mimes:jpeg,png,jpg,gif|max:7048',
            'mbr_email' => 'required|email|unique:members,email,'.$this->route('member')->id,
            'roles' => 'required'
        ];
    }
}
