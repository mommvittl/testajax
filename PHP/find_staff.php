<?php
header('Content-Type: text/XML');
require_once("app_config.php");
require_once("php_user_funktion.php");

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}
$funct = trim($_POST['functionHandler']);
$arealSearch = trim($_POST['arealSearch']);
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$birth_day = trim($_POST['birth_day']);
$criterionBirthData = trim($_POST['criterionBirthData']);
$adress = trim($_POST['adress']);
$email = trim($_POST['email']);
$telephon = trim($_POST['telephon']);
$departament = (int)trim($_POST['departament']);
$position = trim($_POST['position']);
$enrolment_data = trim($_POST['enrolment_data']);
$criterionData = trim($_POST['criterionData']);
$worked = trim($_POST['worked']);
if( empty($funct) && empty($name) && empty($surname) && empty($birth_day) && empty($adress) && empty($email) && empty($telephon)
	&& empty($departament) && empty($position) && empty($enrolment_data)  && empty($worked)){
		 exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Нет критериев поиска."));
	}
if (!$db->set_charset("utf8")) { exit(myf_err_xml("Sorry...<br>Ошибка при обращении к базе данных")); } 
$funct = $db->real_escape_string(substr($funct,0,50));  
$name = $db->real_escape_string(substr($name,0,50));  
$surname = $db->real_escape_string(substr($surname,0,50));
if ($birth_day){
	list($year,$month,$day) = explode("-",$birth_day);
	if(!checkdate($month,$day,$year)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректная дата рождения.")); } 
}
$adress = $db->real_escape_string(substr($adress,0,100));  
$email = $db->real_escape_string(substr($email,0,100)); 
$telephon = $db->real_escape_string(substr($telephon,0,50));
$position = $db->real_escape_string(substr($position,0,50));
if($enrolment_data) {
	list($year,$month,$day) = explode("-",$enrolment_data);
	if(!checkdate($month,$day,$year)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Некорректная дата приема на работу.")); }
} 
$str_query = "select staff_inform.* from staff_inform,staff_working WHERE 1 AND staff_inform.id_staff=staff_working.id_worker ";
if ($name) { $str_query .= " AND staff_inform.name like('%".$name."%') ";}
if ($surname) { $str_query .= " AND staff_inform.surname like('%".$surname."%')";}
if ($birth_day) { 
	switch($criterionBirthData){
		case "before":
			$criterion_search = "<";
			break;
		case "really":
			$criterion_search = "=";
			break;
		default :
			$criterion_search = ">";
			break;	
	}
	$str_query .= " AND staff_inform.birth_day".$criterion_search."'".$birth_day."'";
}
if ($adress) { $str_query .= " AND staff_inform.adress like ('%".$adress."%') ";}	 	
if ($email) { $str_query .= " AND staff_inform.email like ('%".$email."%') ";}	 	
if ($telephon) { $str_query .= " AND staff_inform.telephon like ('%".$telephon."%') ";}	 	
if ($departament) { $str_query .= " AND staff_working.departament='".$departament."' ";}	 	
if ($position) { $str_query .= " AND staff_working.position='".$position."' ";}	 	
if ($enrolment_data) { 
	switch($criterionData){
		case "before":
			$criterion_search = "<";
			break;
		case "really":
			$criterion_search = "=";
			break;
		default :
			$criterion_search = ">";
			break;	
	}
	$str_query .= " AND staff_working.enrolment_data".$criterion_search."'".$enrolment_data."'";
} 
if ($worked == 'noworked') { $str_query .= " AND staff_inform.work='0' ;"; }	
  else{  $str_query .= " AND work='1' ;";}
$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);	
exit($xmlString);
?>