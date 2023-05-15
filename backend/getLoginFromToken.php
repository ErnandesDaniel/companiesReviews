<?php

require_once "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function getLoginFromToken($token){
	
	$secretKey = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew1';
			
	$decoded = JWT::decode($token, new Key($secretKey, 'HS256'));//Получаем декодированный токен
			
	$decoded_array = (array) $decoded;//Получаем из токена массив	
			
	$login=$decoded_array['login'];
	
	return $login;
		
}

?>