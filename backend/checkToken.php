<?

require_once "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkToken($token){
	
	$tokenIsValid=false;
	
	if($token!=null){
		
		$secretKey = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew1';
		
		try{//если декодирование токена удастся, то токен действителен
		
			$decoded = JWT::decode($token, new Key($secretKey, 'HS256'));//Получаем декодированный токен
			
			$tokenIsValid=true;
			
			//Если декодирование токена не удастся, то токен недействителен

		}catch(Exception $e){
			
			//$tokenIsValid===false
			
		}
	
	}

	return $tokenIsValid;
	
}

?>