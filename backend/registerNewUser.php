<?php

require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "getToken.php";

function registerUser($login, $password){
	
	//Создаем пользователя
	$result=SQL_query("INSERT INTO users (login, password) VALUES ('$login', '$password')");
	
	//Если пользователь создан успешно, то отправляем данные
	if($result==true){
		
		//Создание токена
		$token=getToken($login);
		
		//Отправка сообщения об успешном сохранении данных в базе данных
		sendResponse(true,'userWasCreated',$token);
		
	}else{
		
		sendResponse(false,'databaseConnectionError');
		
	}

}


//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);

$login=$data['login'];

$password=$data['password'];

if(strlen($login)>0 or strlen($password)>6){
	
	$result=SQL_query('SELECT COUNT(*) FROM users');//Получаем количество пользователей в таблице пользователей (объект ответа)
	
	$countOfUser=($result->fetch_all())[0][0];//Получаем число пользователей из объекта ответа

	if($countOfUser==0){//Если количество пользователей равно нулю,то создаем нового пользователя

		registerUser($login, $password);
		
	}else{//Если количество пользователей больше нуля, то:

		//Проверка на существование пользователя с таким же логином

		$result=SQL_query("SELECT * FROM users WHERE login='$login'");
		$result=$result->fetch_all(MYSQLI_ASSOC);//Пытаемся преобразовать результат в массив

		//Если пользователя с таким логином не существует, то создаем пользователя
		if($result==null){

			registerUser($login, $password);

		}else{
			
			//Пользователь с таким логином уже существует, нужен другой логин
			sendResponse(false,'loginIsUsed');
				
		}
		
	}


}else{
	
	//Пользователь с таким логином уже существует, нужен другой логин
	sendResponse(false,'invalidUsernameOrPassword');
	
}

?>