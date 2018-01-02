<?php 

namespace App\Http\Requests;
 
use Response;
use Illuminate\Foundation\Http\FormRequest;
 
class AuthRequest extends FormRequest {
 
    public function rules()
    {
        return [
         "email"   => "required",
         "password"  => "required",
        ];
    }
 
    public function authorize()
    {
        return true;
    }
 
}