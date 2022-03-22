<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseOrderUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
