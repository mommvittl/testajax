<?php
header('Content-Type: text/XML');
header(' Cache-Control: no-cache');
require_once("app_config.php");
require_once("php_user_funktion.php");

$funct = trim($_GET['functionHandler']);
$deleteStaffId = trim($_GET['deleteStaffId']);
$dom = new DOMDocument();

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}
if (myf_find_staff($db,$deleteStaffId)){	
	$db->autocommit(FALSE);
	$str_date =  date( "Y-m-d" );
	$str_query = "UPDATE staff_inform SET work='0' WHERE id_staff='".$deleteStaffId."'";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 1")); } ;
	$str_query = "UPDATE staff_working SET discharge_data='".$str_date."' WHERE id_worker='".$deleteStaffId."'";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных 2")); } ;
	if (!$db->commit()){ exit(myf_err_xml("Не удалось соединиться с Базой данных 3")); }	
	$db->autocommit(true);
	exit(myf_inform_xml("Сотрудник успешно уволен")); 
}else{
	exit(myf_inform_xml("error<br>Проверьте целостность данных<br>Ошибка данных БД"));
}
exit;
// ф-я проверки наличия в БД сотрудника с именем $name и фамилией $surname.Возвращает true или false
function myf_find_staff($db,$deleteStaffId){
	$str_query = "select COUNT(*) from staff_inform WHERE work='1' AND id_staff='".$deleteStaffId."' ;";
	$result = $db->query($str_query);
	list($col) = $result->fetch_row();
	return ($col)?true:false;
}
?>