<?php

namespace app\supports;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT as JWTJWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;

class JWT
{
    public static function validateJwt()
    {
        try {
            if (!isset($_SERVER['HTTP_AUTHORIZATION']) && empty($_SERVER['HTTP_AUTHORIZATION'])) {
                echo json_encode(["rrror" => "usuario não autenticado"]);
                http_response_code(401);
                exit;
            }
            $bearer = $_SERVER['HTTP_AUTHORIZATION'];
            $token = str_contains($bearer, "Bearer") ? trim(str_replace("Bearer", "", $bearer)) : $bearer;
            $decode = JWTJWT::decode($token, new Key($_ENV['KEYJWT'], 'HS256'));
            return $decode;
        } catch (ExpiredException $e) {
            echo json_encode($e->getMessage());
            http_response_code(401);
            exit;
        } catch (InvalidArgumentException $e) {
            echo json_encode($e->getMessage());
            http_response_code(401);
            exit;
        } catch (SignatureInvalidException $e) {
            echo json_encode($e->getMessage());
            http_response_code(401);
            exit;
        }
    }
    public static function createJwt()
    {
        $payload = [
            'exp' => strtotime("+10 hours", time()),
            'iat' => time(),
            'data' => [
                'email' => "email@email.com"
            ]
        ];
        $jwt = JWTJWT::encode($payload, $_ENV['KEYJWT'], 'HS256');
        return $jwt;
    }
}
