<?php 

namespace App\Http\Requests;
 
use Response;
use Illuminate\Foundation\Http\FormRequest;
 
class RegisterRequest extends FormRequest {
    
    protected $redirectRoute = 'getRegister';

    public function rules()
    {
        return [
         "email"   => "required|email|unique:users,email",
         "password"  => "required|min:6",
        ];
    }
 
    public function authorize()
    {
        return true;
    }
 
}