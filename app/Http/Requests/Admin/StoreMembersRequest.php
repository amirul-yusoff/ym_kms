<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Axiom\Rules\StrongPassword;

class StoreMembersRequest extends FormRequest
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
            'password' => ['bail', 'required', new StrongPassword, 'confirmed'],
            // 'employee_code' => 'required|unique:members',
            'employee_name' => 'required',
            // 'department' => 'required',
            // 'position' => 'required',
            // 'image' =>'image|mimes:jpeg,png,jpg,gif|max:7048',
            'mbr_email' => 'required|email|unique:members',
            'roles' => 'required'
        ];
    }
}
