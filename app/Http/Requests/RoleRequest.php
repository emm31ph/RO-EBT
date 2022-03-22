<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
         

           $rules = [ 
            'description' => 'required|max:255',
             
        ]; 
         switch ($this->getMethod()) {
            case 'POST': 
                $rules +=['display_name' => 'required|min:4|unique:roles'];   
                $rules +=['name' => 'required|min:4|unique:roles'];   
                break;
            case  'PUT':
                $rules +=['display_name' => 'required|min:4|unique:roles,display_name'.(!isset($this->role)?",":','.$this->role)];
                $rules +=['name' => 'required|min:4|unique:roles,name'.(!isset($this->role)?",":','.$this->role)];
            break;
            default:
                # code...
                break;
        }   
        return $rules; 

    }
       public function messages(){
        return [
            'display_name.required' => 'Display name is required',
            'name.required' => 'Slug is required',
            'description.required' => 'Description is required',
            'display_name.unique' => 'Display name is already exist', 
            'name.unique' => 'Slug is already exist', 
        ];
    }
}