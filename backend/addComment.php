<?php


require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "checkToken.php";
require "getLoginFromToken.php";
require "getIDOfUser.php";

//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);

$data['time']=date('Y-m-d h:i:s', time());

//Проверяем токен

if(checkToken($data['token'])==true){
	
	//Получаем из токена логин
	$login=getLoginFromToken($data['token']);
		
	//По логину получаем id пользователя
	$user_id=getIDOfUser($login);
	
	$result=SQL_query("

		INSERT INTO comments (company_id, user_id, time, content, comment_type)

		VALUES ({$data['company_id']}, $user_id,'{$data['time']}',
		'{$data['content']}','{$data['comment_type']}')"
		
		);
	
	//Если компания успешно создана, то отправляем данные пользователю
	if($result==true){
		
		//Отправка сообщения об успешном сохранении данных в базе данных
		sendResponse(true,'commentWasAdded');
		
	}else{
		
		//Иначе отпарвляем сообщение об ошибке
		sendResponse(false,'databaseConnectionError');
		
	}	
	

}else{
	
	sendResponse(false,'userNotFound');
	
}


























?>