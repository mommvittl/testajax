<?php
header('Content-Type: text/XML');
header(' Cache-Control: no-cache');
require_once("app_config.php");
require_once("php_user_funktion.php");

$funct = trim($_GET['functionHandler']);
$name = trim($_GET['name']);
$surname = trim($_GET['surname']);
$birth_day = trim($_GET['birth_day']);
$adress = trim($_GET['adress']);
$email = trim($_GET['email']);
$telephon = trim($_GET['telephon']);
$departament = (int)trim($_GET['departament']);
$position = trim($_GET['position']);
$enrolment_data = trim($_GET['enrolment_data']);

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { exit(myf_err_xml("Не удалось соединиться с Базой данных add_staff")); }
//валидация зашедших данных
if( empty($funct) || empty($name) || empty($surname) || empty($birth_day) || empty($adress) || empty($email) || empty($telephon)
	|| empty($departament) || empty($position) || empty($enrolment_data) ){		
		 exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Не все поля формы заполнены."));
	}
if (!$db->set_charset("utf8")) { exit(myf_err_xml("Sorry...<br>Ошибка при обращении к базе данных")); } 
$funct = $db->real_escape_string(substr($funct,0,50));  
$name = $db->real_escape_string(substr($name,0,50));  
$surname = $db->real_escape_string(substr($surname,0,50));
list($year,$month,$day) = explode("-",$birth_day);
if(!checkdate($month,$day,$year)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректная дата рождения.")); }  
$adress = $db->real_escape_string(substr($adress,0,100));  
$email = $db->real_escape_string(substr($email,0,100)); 
if (  !preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9_\.\-]+.[\.A-Za-z0-9]{2,}$/U",$email) ) {
	exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректный Email."));
}
$telephon = $db->real_escape_string(substr($telephon,0,50));  
list($year,$month,$day) = explode("-",$enrolment_data);
if(!checkdate($month,$day,$year)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректная дата приема на работу.")); }     
//проверка наличия такого сотрудника среди работающего персонала
//и , если нет - добавление в staff_inform и staff_working

if (myf_find_staff($db,$name,$surname,$birth_day)) {
	exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Такой сотрудник уже есть в базе."));
}else{ 
	$db->autocommit(FALSE);
	$str_query = "INSERT INTO staff_inform VALUES (NULL, '".$name."','".$surname."','".$birth_day."','".$adress."','".$email."','".$telephon."','NULL','1','NULL');";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 11")); } ;
	$str_query = "INSERT INTO staff_working VALUES (LAST_INSERT_ID(), '".$departament."','".$position."','".$enrolment_data."','NULL','NULL');";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 2")); } ;
	if (!$db->commit()){ exit(myf_err_xml("Не удалось соединиться с Базой данных 3")); }	
	$db->autocommit(true);
	$str_query = "select id_staff from staff_inform WHERE work='1' AND name='".$name."' AND surname='".$surname."' AND birth_day='".$birth_day."';";
	exit(myf_get_staff_iftorm($funct,$db,$str_query)); 
}
// ф-я проверки наличия в БД сотрудника с именем $name и фамилией $surname.Возвращает true или false
function myf_find_staff($db,$name,$surname,$birth_day){
	$str_query = "select COUNT(*) from staff_inform WHERE work='1' AND name='".$name."' AND surname='".$surname."' AND birth_day='".$birth_day."';";
	$result = $db->query($str_query);
	list($col) = $result->fetch_row();
	return ($col)?true:false;
}
?>