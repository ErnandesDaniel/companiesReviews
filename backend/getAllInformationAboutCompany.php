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
	
	//По логину получаем id пользователя
	$user_id=getIDOfUser($login);
	
	//Получаем всю информацию о компании
	$result=SQL_query("SELECT * FROM companies WHERE id={$data['company_id']}");
	
	if($result->num_rows==0){
		
		//Если компания не нашлась, то пишем об ошибке
		sendResponse(false,'companyNotExist');	
			
	}else{
		
		$InformationAboutCompany=$result->fetch_all(MYSQLI_ASSOC);
		
		foreach ($InformationAboutCompany as &$company){
			unset($company['id']);
			unset($company['owner_id']);
				
		}//разорвать ссылку на последний элемент
		unset($company); 
		
		//Получаем все комментарии пользователя к компании
			
		$result=SQL_query("SELECT * FROM comments WHERE company_id={$data['company_id']} AND user_id=$user_id");
		
		if($result!=null){
		
			$comments=$result->fetch_all(MYSQLI_ASSOC);
				
			//Убираем лишние данные в комментариях
				
			foreach ($comments as &$comment){
					
				unset($comment['company_id']);
				unset($comment['id']);
				unset($comment['user_id']);
				//В качестве логина пользователя, оставившего комментарий, берем логин пользователя, отправившего токен,
				//так как отсортированные комментарии принадлежат ему
				$comment['login']=$login;	
			}//разорвать ссылку на последний элемент
			unset($comment);
		
		}else{
			
			$comments=[];

		}			
			
		//Добавляем комментарии к информации о компании
		$InformationAboutCompany[0]['comments']=$comments;
		
		sendResponse(true,'allInformationAboutCompany',$InformationAboutCompany);
		
	}
	
	
}else{
		
	sendResponse(false,'userNotFound');
		
}


?>