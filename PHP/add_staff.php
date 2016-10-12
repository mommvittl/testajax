<?php
header('Content-Type: text/XML');
require_once("app_config.php");
$funct = trim($_POST['functionHandler']);
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$birth_day = trim($_POST['birth_day']);
$adress = trim($_POST['adress']);
$email = trim($_POST['email']);
$telephon = trim($_POST['telephon']);
$resume = trim($_POST['resume']);
$departament = (int)trim($_POST['departament']);
$position = trim($_POST['position']);
$enrolment_data = trim($_POST['enrolment_data']);

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { exit(myf_err_xml("Не удалось соединиться с Базой данных")); }
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
	$str_query = "INSERT INTO staff_inform VALUES (NULL, '".$name."','".$surname."','".$birth_day."','".$adress."','".$email."','".$telephon."','".$resume."','1');";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 1")); } ;
	$str_query = "INSERT INTO staff_working VALUES (LAST_INSERT_ID(), '".$departament."','".$position."','".$enrolment_data."','NULL','NULL');";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 2")); } ;
	if (!$db->commit()){ exit(myf_err_xml("Не удалось соединиться с Базой данных 3")); }	
	$db->autocommit(true);
	exit(myf_inform_xml("Сотрудник успешно добавлен")); 
}
// ф-я проверки наличия в БД сотрудника с именем $name и фамилией $surname.Возвращает true или false
function myf_find_staff($db,$name,$surname,$birth_day){
	$str_query = "select COUNT(*) from staff_inform WHERE work='1' AND name='".$name."' AND surname='".$surname."' AND birth_day='".$birth_day."';";
	$result = $db->query($str_query);
	list($col) = $result->fetch_row();
	return ($col)?true:false;
}
//ф-я возврата документа xml <error>
function myf_err_xml($str_error){
	$dom_err = new DOMDocument();
	$error = $dom_err->createElement('error',$str_error);
	$dom_err->appendChild($error);
	$xmlErrStr = $dom_err->saveXML();
	return $xmlErrStr;
}
//ф-я возврата документа xml <underreporting>
function myf_inform_xml($str_inform){
	$dom_inform = new DOMDocument();
	$inform = $dom_inform->createElement('underreporting',$str_inform);
	$dom_inform->appendChild($inform);
	$xmlInformStr = $dom_inform->saveXML();
	return $xmlInformStr;
}
?>