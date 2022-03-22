<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    { 
          $rules = [ 
            'name' => 'required|max:255',
            'roles' => 'required',
        ]; 
         switch ($this->getMethod()) {
            case 'POST': 
                $rules +=['email' => 'required|email|unique:users'];   
                $rules +=['username' => 'required|min:5|unique:users'];           
                $rules +=['password' => 'required|min:6'];
                break;
            case  'PUT':
                $rules +=['email' => 'required|email|unique:users,email'.(!isset($this->user)?",":','.$this->user)];
                $rules +=['username' => 'required|min:5|unique:users,username'.(!isset($this->user)?",":','.$this->user)];
            break;
            default:
                # code...
                break;
        }   
        return $rules; 
    }


     public function messages(){
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email address field is required.',
            'email.unique' => 'The email address is already taken.',
            'username.unique' => 'The username is already taken.',
            'username.required' => 'The username field is required.',
            'email.email' => 'Please enter a vaild email address',
            'roles.required' => 'The roles field is required.',
        ];
    }
}