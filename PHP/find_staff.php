<?php
header('Content-Type: text/XML');
header(' Cache-Control: no-cache');
require_once("app_config.php");
require_once("php_user_funktion.php");

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}
$funct = trim($_GET['functionHandler']);
$stopSearch = trim($_GET['stopSearch']);
$arealSearch = trim($_GET['arealSearch']);
$name = trim($_GET['name']);
$surname = trim($_GET['surname']);
$birth_day = trim($_GET['birth_day']);
$criterionBirthData = trim($_GET['criterionBirthData']);
$adress = trim($_GET['adress']);
$email = trim($_GET['email']);
$telephon = trim($_GET['telephon']);
$departament = (int)trim($_GET['departament']);
$position = trim($_GET['position']);
$enrolment_data = trim($_GET['enrolment_data']);
$criterionData = trim($_GET['criterionData']);
$worked = trim($_GET['worked']);
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
$str_query = "select staff_inform.* from staff_inform,staff_working WHERE 1 AND staff_inform.id_staff=staff_working.id_worker   ";

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
if ($worked == 'noworked') { $str_query .= " AND staff_inform.work='0' ORDER BY name;"; }	
  else{  $str_query .= " AND work='1'  AND staff_working.discharge_data='0000-00-00' ;";}
if ($arealSearch == 'raund') { $fflag_er = "0"; }
  else {  $fflag_er = "1"; }
$xmlString = myf_get_staff_iftorm($funct,$db,$str_query, $fflag_er);
if ($arealSearch != 'raund' ) { exit($xmlString); }

//Если задан параметр arealSearch = raund - ищем на филиалах.
if (($arealSearch) == 'raund' && ($stopSearch != 'stop')){
	$query_param = $_SERVER['QUERY_STRING'];
	$query_param .= "&stopSearch=stop";
	$url = "ajax/www/PHP/find_staff.php";
	$result = get_web_page( $url,$query_param );
	if (($result['errno'] == 0 ) && ($result['http_code'] == 200)) {$page = $result['content']; }
		else{$page =  myf_inform_xml("Ошибка при обращении к серверу филиала...<br>Данные филиала получить не удалось..."); }	
	$doc1 = new DOMDocument();
	$doc1->loadXML($xmlString);
	$response1 = $doc1->childNodes;
	$response1 = $response1->item(0);
	$resp_name1 = $response1->nodeName;	
	$doc2 = new DOMDocument();
	$doc2->loadXML($page);	
	$response2 = $doc2->childNodes;
	$response2 = $response2->item(0);
	$resp_name2 = $response2->nodeName;	
	if (($resp_name1 != 'response') && ($resp_name2 != 'response')) { exit(myf_inform_xml("По вашему запросу ничего нигде не найдено."));  }
	if (($resp_name1 == 'response') && ($resp_name2 != 'response')) { exit($xmlString);  }
	if (($resp_name1 != 'response') && ($resp_name2 == 'response')) { exit($page); }
	if (($resp_name1 == 'response') && ($resp_name2 == 'response')) {		
		$dom = new DOMDocument();
		$response = $dom->createElement('response');
		$dom->appendChild($response);	
		$nextStaff = $response1->getElementsByTagName("nextStaff");
		for ($i = $nextStaff->length; --$i >= 0; ) {
			$el = $nextStaff->item($i);
			$node = $dom->importNode($el, true);
			$response->appendChild($node);
		}
		$nextStaff = $response2->getElementsByTagName("nextStaff");
		for ($i = $nextStaff->length; --$i >= 0; ) {
			$el = $nextStaff->item($i);
			$node = $dom->importNode($el, true);
			$response->appendChild($node);
		}		
		$functionHandler = $dom->createElement('functionHandler',$funct);
		$response->appendChild($functionHandler);
		$NewxmlString = $dom->saveXML();
		exit($NewxmlString);
	}
}else{ exit($xmlString); }	
?>