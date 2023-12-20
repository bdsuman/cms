<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
class UserController extends Controller
{
   public function UserLogin(Request $request){

        $count=User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->select('id')->first();

       if($count!==null){
           // User Login-> JWT Token Issue
           $token=JWTToken::CreateToken($request->input('email'),$count->id);
           return response()->json([
            'status' => 'success',
            'message' => 'User Login Successful',
            'Bearer Token'=>$token
        ],200);
       }else{
        return $this->failed('unauthorized');
       } 
       
    }

 
}
