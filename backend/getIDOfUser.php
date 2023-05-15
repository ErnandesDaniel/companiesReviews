
<?php

function getIDOfUser($login){
		
	//Получаем ID пользователя по логину
	$result=SQL_query("SELECT id from users WHERE login='$login'");
	$result=$result->fetch_all(MYSQLI_ASSOC);//Пытаемся преобразовать результат в массив
	$user_id=$result[0]['id'];
	
	return $user_id;
	
}


?>