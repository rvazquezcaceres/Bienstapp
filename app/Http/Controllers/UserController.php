<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Helpers\Token;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->register($request);
        $data_token = [
            "email" => $user->email,
        ];
        $token = new Token($data_token);
        $token_encode = $token->encode();
        return response()->json([
            "token" => $token_encode
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = $request->data_token->email;
        $user = User::where('email', $email)->first(); 
        return response()->json([
            "User" => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $email = $request->data_token->email;
        $user = User::where('email', $email)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = $request->data_token->email;
        $user = User::where('email', $email)->first();
        $user->delete();
            return response()->json([
                "message" => 'el usuario ha sido eliminado'
            ], 200);
    }

    public function login(Request $request)
    {
        $data_token = [
            'email' => $request->email,
        ];
        $user = User::where($data_token)->first();
        if($user->password == $request->password)
        {
            $token = new Token($data_token);
            $token_encode = $token->encode();
            return response()->json([
                "token" => $token_encode
            ], 200);
        }
        return response()->json([
            "message" => "Unauthorized"
        ], 401);
    }

    public function password_recover(Request $request)
    {
        $data_token = [
            "email" => $request->email
        ];
        $user = User::where('email', $request->email)->first();
        //var_dump($user->email);exit;
        if(isset($user))
        {
            $number_rand = rand(10000, 99999);
            $array = ['#','@','!','$','%','&','?','¿','¡','!'];
            // mirar aleatorio de 0 a $array.count, insertar en vez de #
            $newPassword = "ChangePassword".$number_rand."#";
            var_dump($newPassword);exit();
            $message = ("El numero para recuperar tu contraseña es: " . $number_rand);
            $to = $user->email;
            $titulo = 'recuperar contraseña';
            $cabeceras = 'From: recuperar_contraseñas@cev.com'. "\r\n" . 'Replay-To: $user->email' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            mail($to, $titulo, $message, $cabeceras);
            return response()->json([
                "message" => 'Email enviado'
            ], 200);
        } 
        else 
        {
            return response()->json([
                "message" => 'Codigo erroneo'
            ], 200);
        }
    }
}
