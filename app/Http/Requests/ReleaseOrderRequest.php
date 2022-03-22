<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

         $rules = [

            
            'dateInput' => 'required',
            //'driver' => 'required',
            //'trucker' => 'required',
            // 'plate' => 'required',
            // 'truck' => 'required',
            //'area' => 'required', 
        ];

          switch ($this->getMethod()) {
            case 'POST': 
                $rules += ['rono' => 'required|unique:releaseprocess,ro_no'];
                break;
            case  'PUT':
                $rules += ['rono' => 'required|unique:releaseprocess,ro_no'.(!isset($this->rono)?",":','.$this->rono)];
                 break;
            default:
                # code...
                break;
        }   
        return $rules; 
       
    }
    public function messages()
    {
        return [
            'rono.required' => 'Release Order No. is required!',
            'rono.unique' => 'The Release Order No. has already been taken.',
            'dateInput.required' => 'Delivery Date is required!',
            'driver.required' => 'Driver Name is required!',
            // 'plate.required' => 'Plate No. is required!',
            // 'truck.required' => 'Truck No. is required!',
            'trucker.required' => 'Trucker is required!', 
            'area.required' => 'Area is required!', 
        ];
    }
}
