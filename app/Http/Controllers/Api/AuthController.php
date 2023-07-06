<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{

    use ApiResponse;

    public function register(Request $request){

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('myApp')->plainTextToken;
        // $rule=Rule::find(2);
        // $user->rules()->attach($rule);
        return $this->apiResponse($token,'Registeration success', 200);
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
        return $this->errorResponse('Login information is invalid', 401);
     }

    $user = User::where('email', $request['email'])->firstOrFail();
    $token = $user->createToken('myApp')->plainTextToken;
    $data['name']=$user->name;
    $data['token']=$token;
        
        return $this->apiResponse($data,'Login success', 200);
     }

     public function logout(Request $request){
        auth()->user()->currentAccessToken()->delete();
        return $this->SuccessResponse('user logged out');
     }
     
    
}

