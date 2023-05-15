<?php

require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "getToken.php";

//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);

$login=$data['login'];

$password=$data['password'];

$result=SQL_query('SELECT COUNT(*) FROM users');//Получаем количество пользователей в таблице пользователей (объект ответа)
$countOfUser=($result->fetch_all())[0][0];//Получаем число пользователей из объекта ответа

if($countOfUser==0){//Если количество пользователей равно нулю,то создаем нового пользователя

	sendResponse(false,'userNotFound');
	
}else{//Если количество пользователей больше нуля, то:

	//Проверка на существование пользователя с таким же логином

	$result=SQL_query("SELECT * FROM users WHERE login='$login' and password='$password'");
	$result=$result->fetch_all(MYSQLI_ASSOC);//Пытаемся преобразовать результат в массив

	//Если пользователя с таким логином и паролем не существует, то выдаем ошибку
	if($result==null){

		sendResponse(false,'userNotFound');

	}else{
		
		//Создание токена
		$token=getToken($login);
		
		//Пользователь с таким логином уже существует, нужен другой логин
		sendResponse(true,'userFound',$token);
			
	}
	
}



?>