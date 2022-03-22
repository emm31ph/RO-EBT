<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules  = [];
       if($this->input('permissionvalue')=='basic'){
        $rules +=['display_name' => 'required|min:3']; 
        $rules +=['name' => 'required|min:3|unique:permissions']; 
        
       }

       if($this->input('permissionvalue')=='crud'){
        $rules +=['resource' => 'required|min:3']; 
       }


       return $rules;
    }

      public function messages(){
        return [
            'display_name.required' => 'The name field is required.', 
            'name.required' => 'The Slug field is required.', 
            'resource.required' => 'The resource field is required.', 
        ];
    }
}