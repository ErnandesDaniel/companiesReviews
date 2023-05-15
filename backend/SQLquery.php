<?php

//Подключение к базе данных

function SQL_query($query){

	$host = "localhost";// локалхост
	$db_name = "togolden";//имя базы данных
	$username = "root";// имя пользователя MySQL
	$password = "";// пароль если существует(если не существует, то равен пустой строке)

	$mysqli = new mysqli($host, $username, $password, $db_name);//Создаем объект соединения с базой данных
	$mysqli->set_charset("utf8mb4");// задаем кодировку
	$result = $mysqli->query($query);// Получение результата запроса к базе данных
	$mysqli->close();
	return $result;//Возвращаем результат запроса
}


?>
