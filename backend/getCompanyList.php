<?php

require "setHeader.php";
require "SQLquery.php";
require "sendResponse.php";
require "checkToken.php";
require "getLoginFromToken.php";
require "getIDOfUser.php";

//Получаем данные
$data = json_decode(file_get_contents('php://input'),true);

if($data['token']==''){

	$result=SQL_query("SELECT * FROM companies");
	
	
	
	if($result!=null){
		
		$result=$result->fetch_all(MYSQLI_ASSOC);
			
		//Преобразовываем массив: удаляем лишнюю информацию
		foreach ($result as &$company){
				
			unset($company['inn']);
			unset($company['general_information']);
			unset($company['owner_id']);
			unset($company['id']);
		}//разорвать ссылку на последний элемент
		unset($company);
		sendResponse(true,'companiesList',$result);	
		
	}else{
		
		sendResponse(true,'companiesList',[]);	
		
	}
	
}else{
	//Проверяем токен
	if(checkToken($data['token'])==true){
		
		//Получаем из токена логин
		$login=getLoginFromToken($data['token']);
		
		//По логину получаем id пользователя
		$user_id=getIDOfUser($login);
		
		//Получаем список всех компаний
		$result=SQL_query("SELECT * FROM companies");
				
		if($result!=null){
		
			$result=$result->fetch_all(MYSQLI_ASSOC);
			
			//Преобразовываем массив: указываем, какие элементы (компании) принадлежат нам, удаляем лишнюю информацию
			foreach ($result as &$company){
				
				unset($company['inn']);
				unset($company['general_information']);
				
				if($user_id==$company['owner_id']){
				
					$company['editable']=true;
				
				}else{
					
					$company['editable']=false;
					
				}
				unset($company['owner_id']);
				
			}//разорвать ссылку на последний элемент
			unset($company); 
			
			sendResponse(true,'companiesList',$result);	
			
		}else{
			
			sendResponse(true,'companiesList',[]);	
			
		}
		
	}else{
		
		sendResponse(false,'userNotFound');
		
	}

}

?>