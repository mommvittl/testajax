<?php
header('Content-Type: text/XML');
header(' Cache-Control: no-cache');
require_once("app_config.php");
require_once("php_user_funktion.php");

$funct = trim($_GET['functionHandler']);
$id_staff = (int)trim($_GET['id_staff']);
$departament = (int)trim($_GET['departament']);
$position = trim($_GET['position']);
$discharge_data = trim($_GET['discharge_data']);

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { exit(myf_err_xml("Не удалось соединиться с Базой данных")); }
//валидация зашедших данных
if( empty($funct) || empty($id_staff) || empty($departament) || empty($position) || empty($discharge_data) ){
		 exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Не все поля формы заполнены."));
	}
if (!$db->set_charset("utf8")) { exit(myf_err_xml("Sorry...<br>Ошибка при обращении к базе данных")); } 
$funct = $db->real_escape_string(substr($funct,0,50));  
$position = $db->real_escape_string(substr($position,0,50));  
list($year,$month,$day) = explode("-",$discharge_data);
if(!checkdate($month,$day,$year)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректная дата перевода.")); }   
//проверка наличия такого сотрудника среди работающего персонала
//и , если нет - добавление в staff_inform и staff_working
if ( !myf_search_id($db,$id_staff) ) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Такого сотрудника нет в базе.")); }
if ( !myf_search_departament($db,$departament))  { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Такого департамента нет в базе.")); }
$db->autocommit(FALSE);
	$str_query = "UPDATE staff_working SET discharge_data='".$discharge_data."' WHERE id_worker=".$id_staff." ;";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 1")); } ;
	$str_query = "INSERT INTO staff_working VALUES ('".$id_staff."', '".$departament."','".$position."','".$discharge_data."','NULL','NULL');";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 2")); } ;
	if (!$db->commit()){ exit(myf_err_xml("Не удалось соединиться с Базой данных 3")); }	
	$db->autocommit(true);
	exit(myf_inform_xml("Сотрудник успешно переведен")); 

//--------------------------------------------------------------------------------------------------

//проверка наличия переданного департамента в БД. Возврат true/false
function myf_search_departament($db,$departament){
	$str_query = "select count(*) from departament WHERE id_dep='".$departament."' ;";
	$result = $db->query($str_query);
	list($col) = $result->fetch_row();
	return ($col)?true:false;
}
?>