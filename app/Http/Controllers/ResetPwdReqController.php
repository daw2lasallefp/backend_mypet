<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Employees;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ResetPwdReqController extends Controller
{
    public function reqForgotPassword(Request $request){
        if(!$this->validEmail($request->email)) {
            return response()->json([
                'message' => 'El correo electrónico no se encuentra en la base de datos.'
            ], Response::HTTP_NOT_FOUND);
        } else {
            $this->sendEmail($request->email);
            return response()->json([
                'message' => 'Correo electrónico de recuperación de contraseña enviado.'
            ], Response::HTTP_OK);            
        }
    }


    public function sendEmail($email){
        $token = $this->createToken($email);
        Mail::to($email)->send(new SendMail($token));
    }

    public function validEmail($email) {
   
         $user = Employees::where('email', $email)->first(); 
         
         if(!$user){
            $user = Clients::where('email', $email)->first(); 
         }
        return $user;
        
    }

    public function createToken($email){
      $isToken = DB::table('password_resets')->where('email', $email)->first();

      if($isToken) {
        return $isToken->token;
      }

      $token = Str::random(80);;
      $this->saveToken($token, $email);
      return $token;
    }

    public function saveToken($token, $email){
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()            
        ]);
    }
}
