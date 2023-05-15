<?php

require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "checkToken.php";
require "getLoginFromToken.php";
require "getIDOfUser.php";

//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);

//Проверяем токен

if(checkToken($data['token'])==true){
	
	//Получаем из токена логин
	$login=getLoginFromToken($data['token']);
		
	//По логину получаем id пользователя (владелец компании, который может ее удалить)
	$owner_id=getIDOfUser($login);
	
	$result=SQL_query("

		INSERT INTO companies (owner_id, name, inn, general_information, general_director, address, telephone) 

		VALUES ('$owner_id', '{$data['name']}', '{$data['inn']}','{$data['general_information']}',
		'{$data['general_director']}','{$data['address']}','{$data['telephone']}')"
		
		);
	
	//Если компания успешно создана, то отправляем данные пользователю
	if($result==true){
		
		//Отправка сообщения об успешном сохранении данных в базе данных
		sendResponse(true,'companyWasAdded');
		
	}else{
		
		//Иначе отпарвляем сообщение об ошибке
		sendResponse(false,'databaseConnectionError');
		
	}	
	
}else{
	
	sendResponse(false,'userNotFound');
	
}


?>