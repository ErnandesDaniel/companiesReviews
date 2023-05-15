<?php

require_once "vendor/autoload.php";
use Firebase\JWT\JWT;

function getToken($login){
	
	$secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew1';
	
	$issuedAt = time();// Issued at: time when the token was generated];	
	
	$payload = ['login'=>$login, 'iat'  => $issuedAt];         
		
	$token = JWT::encode($payload, $secretKey, 'HS256');

	return $token;
		
}


?>