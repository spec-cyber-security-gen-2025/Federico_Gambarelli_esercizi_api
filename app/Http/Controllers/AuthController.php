<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            // return $this->sendError('Validation Error.', $validator->errors());   
            return response()->json(['error' =>  $validator->errors()], 403);    
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        
        return response()->json([
            'data' => $success,
            'links' => [
                'self' => [
                    'href' => url('/api/register'),
                    'method' => 'POST'
                ],
                'all_books' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ]
            ]
        ]);
        //return $this->sendResponse($success, 'User register successfully.');
    }
   
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            
            $user = Auth::user(); 
            
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            
            return response()->json([
                'data' => $success,
                'links' => [
                    'self' => [
                        'href' => url('/api/login'),
                        'method' => 'POST'
                    ],
                    'all_books' => [
                        'href' => url('/api/books'),
                        'method' => 'GET'
                    ]
                ]
            ]);
            // return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
