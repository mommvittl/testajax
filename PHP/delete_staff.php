<?php
header('Content-Type: text/XML');
$funct = trim($_POST['functionHandler']);
$deleteStaffId = trim($_POST['deleteStaffId']);
$dom = new DOMDocument();
require_once("app_config.php");
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