<?php

require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "checkToken.php";
require "getLoginFromToken.php";
require "getIDOfUser.php";

//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);


if(checkToken($data['token'])==true){
	
	//Получаем из токена логин
	$login=getLoginFromToken($data['token']);
		
	//По логину получаем id пользователя
	$user_id=getIDOfUser($login);
	
	//Преобразуем company_id из строки в число
	$data['company_id']=(int)$data['company_id'];
	
	//Удаляем компанию
	$firstResult=SQL_query("DELETE FROM companies WHERE id={$data['company_id']}  AND owner_id=$user_id");
	
	//Удаляем комментарии к компании
	$secondResult=SQL_query("DELETE FROM comments WHERE company_id={$data['company_id']}  AND user_id=$user_id");
	
	//Если компания успешно создана, то отправляем данные пользователю
	if($firstResult==true and $secondResult==true){
		
		//Отправка сообщения об успешном сохранении данных в базе данных
		sendResponse(true,'companyWasDeleted');
		
	}else{
		
		//Иначе отпарвляем сообщение об ошибке
		sendResponse(false,'databaseConnectionError');
		
	}	
	
	
}else{
	
	sendResponse(false,'userNotFound');
	
}

?>