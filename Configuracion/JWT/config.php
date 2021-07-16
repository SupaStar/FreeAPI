<?php

use Firebase\JWT\JWT;

class JwtAuth
{
    private static $secret_key = 'cjesunpapucho@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function Generar($data)
    {
        $time = time();
        $token = array(
            'exp' => $time + (60 * 60),
            'aud' => self::Aud(),
            'data' => $data
        );
        return JWT::encode($token, self::$secret_key);
    }

    public static function Validar($token)
    {
        if (empty($token)) {
            //throw new Exception("Invalid token supplied.");
            return json_encode(["estado" => false, "detalle" => ["Invalid token supplied."]]);
        }
        try {
            $decode = JWT::decode(
                $token,
                self::$secret_key,
                self::$encrypt
            );
            if ($decode->aud !== self::Aud()) {
                return json_encode(["estado" => false, "detalle" => ["Invalid user logged in."]]);
                //throw new Exception("Invalid user logged in.");
            }
        } catch (Exception $e) {
            return json_encode(["estado" => false, "detalle" => ["Sesion invalida"]]);
        }
        return json_encode(["estado" => true, "detalle" => $decode]);
    }

    public static function obtenerDatos($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}