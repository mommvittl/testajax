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

?>