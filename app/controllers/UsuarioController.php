<?php

namespace Controllers;

use JwtAuth;
use Models\Usuario;
use Rakit\Validation\Validator;
use Illuminate\Http\Request;

class UsuarioController
{
    public static function crearUsuario(Request $request)
    {
        $validator = new Validator;
        $validation = $validator->make($request->all(), [
            'apellidos' => 'required',
            'nombre' => 'required',
            'username' => 'required',
            'mail' => 'required|email',
            'password' => 'required|min:8',
            'rpassword' => 'required|same:password',
        ]);
        $validation->setMessages([
            'apellidos:required' => 'El campo apellidos es requerido',
            'nombre:required' => 'El campo nombre es requerido',
            'username:required' => 'El campo username es requerido',
            'mail:required' => 'El campo email es requerido',
            'mail:email' => 'El campo email no es un email valido',
            'password:required' => 'El password es requerido',
            'password:min' => 'El password debe contener minimo 8 caracteres',
            'rpassword:required' => 'La confirmacion de password es requerida',
            'rpassword:same' => 'La confirmacion de password no coincide',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            return json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
        }
        $usuario = Usuario::where('username', $request->input('username'))->orWhere('email', $request->input('mail'))->first();
        if (isset($usuario)) {
            return json_encode(["estado" => false, "detalle" => ["Usuario o correo repetido"]]);
        }
        $usuario = new Usuario();
        $usuario->apellidos = $request->input('apellidos');
        $usuario->nombre = $request->input('nombre');
        $usuario->username = $request->input('username');
        $usuario->email = $request->input('mail');
        $usuario->password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $usuario->save();
        $JWT = new JwtAuth();
        $token = $JWT->Generar($usuario);
        return json_encode(["estado" => true, 'detalle' => $token]);
    }

    public static function login(Request $request)
    {
        $validator = new Validator;
        $validation = $validator->make($request->all(), [
            'mail' => 'required|email',
            'password' => 'required',
        ]);
        $validation->setMessages([
            'mail:required' => 'El campo email es requerido',
            'mail:email' => 'El campo email no es un email valido',
            'password:required' => 'El password es requerido',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            return json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
        }
        $usuario = Usuario::where('email', $request->input('mail'))->first();
        if (!isset($usuario)) {
            return json_encode(["estado" => false, "detalle" => ["Correo o password incorrectos"]]);
        }
        if (password_verify($request->input('password'), $usuario->password)) {
            $JWT = new JwtAuth();
            $token = $JWT->Generar($usuario);
            return json_encode(["estado" => true, "detalle" => $token]);
        }
        return json_encode(["estado" => false, "detalle" => ["Correo o password incorrectos"]]);
    }
}

?>