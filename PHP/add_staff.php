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
$departament = trim($_POST['departament']);
$enrolment_data = trim($_POST['enrolment_data']);


@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}

	
	

exit;
if (myf_find_staff($db,$name,$surname)) {
	exit(myf_inform_xml("Такой сотрудник уже есть в базе."));
}else{ 
	$str_query = "";
exit(myf_inform_xml("Сотрудник успешно добавлен")); 

}
$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);	
	$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	echo $xmlString;
	
$db->close();

// ф-я проверки наличия в БД сотрудника с именем $name и фамилией $surname.Возвращает true или false
function myf_find_staff($db,$name,$surname){
	$str_query = "select COUNT(*) from staff_inform WHERE name='".$name."' AND surname='".$surname."' ;";
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