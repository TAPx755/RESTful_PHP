<?php
/**
 * Created by PhpStorm.
 * User: paddy.
 * Date: 2019-05-07
 * Time: 11:27
 */

require_once __DIR__."/../lib/php-jwt-master/src/JWT.php";

class JWTToken
{
    public static function validateToken($jwt)
    {
        $public_key = file_get_contents('keys/public_key.key');
        try
        {
            $decoded = JWT::decode($jwt, $public_key, array('RS256'));
        }
        catch(UnexpectedValueException $exception)
        {
            return false;
        }
        catch(SignatureInvalidException $exception)
        {
            return false;
        }
        catch(BeforeValidException $exception)
        {
            return false;
        }
        catch(ExpiredException $exception)
        {
            return false;
        }
    }
    public static function generateToken($token)
    {
        $secret_key = file_get_contents('keys/private_key.key');

        return JWT::encode($token, $secret_key, 'RS256');
    }
}