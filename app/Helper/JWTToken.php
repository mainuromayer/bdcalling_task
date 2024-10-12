<?php

namespace App\Helper;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class JWTToken
{
    public static function CreateToken($user)
    {
        try {
            return JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public static function CreateTokenForSetPassword($userEmail)
    {
        try {
            $customClaims = [
                'email' => $userEmail,
                'exp' => now()->addMinutes(20)->timestamp,
            ];

            return JWTAuth::customClaims($customClaims)->tokenById(0);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public static function VerifyToken($token)
    {
        try {
            $decoded = JWTAuth::setToken($token)->authenticate();
            return $decoded;
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
