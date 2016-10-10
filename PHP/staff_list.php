<?php
header('Content-Type: text/XML');
$funct = trim($_POST['functionHandler']);
$searchList = trim($_POST['searchList']);
$dom = new DOMDocument();
require_once("app_config.php");
@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}
switch ($searchList){
	case 'all':
		$xmlString = myf_get_allstaff_xml($funct,$db);
		break;
	case 'personal':
		$id = trim($_POST['id']);	
		$xmlString = myf_get_personalstaff_xml($funct,$db,$id);
		break;	
	case 'prompting':
		$searchValue = trim($_POST['searchValue']);
		$xmlString = myf_get_prompting_xml($funct,$db,$searchValue);
		break;	
	case 'searchl':
		$surnameSearch = trim($_POST['surnameSearch']);
		$xmlString = myf_get_search_xml($funct,$db,$surnameSearch);
		break;	
	default :
		$xmlString = myf_inform_xml("Неопределенный запрос. Нужно подготовить
			соответствующую функцию обработки...");
		break;
}
exit($xmlString);
//---------------------------------------------------------------------
function myf_get_search_xml($funct,$db,$surnameSearch){
		$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);	
	$str_query = "select * from staff_inform WHERE work='1' and surname='".$surnameSearch."';";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных")); } ;
	$num_rows = $result->num_rows;
	if(!$num_rows){ exit(myf_inform_xml("По вашему запросу в базе данных 
		ничего не найдено.")); }	
	for($i=0; $i<$num_rows; $i++){		
		$row = $result->fetch_assoc();
		$staff = $dom->createElement('nextStaff');
		$response->appendChild($staff);
		foreach($row as $key=>$val){
			$new_element = $dom->createElement($key,$val);
			$staff->appendChild($new_element);
		}	
	}
	$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	return $xmlString;
	
}
//---------------------------------------------------------------------
function myf_get_prompting_xml($funct,$db,$searchValue){
	$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);	
	$str_query = "select id_staff,surname,name from staff_inform WHERE surname like('".$searchValue."%');";
	$result = $db->query($str_query);
	if ($result){
		$num_rows = $result->num_rows;
		for($i=0; $i<$num_rows; $i++){		
			$row = $result->fetch_assoc();
			$staff = $dom->createElement('nextStaff');
			$response->appendChild($staff);
			foreach($row as $key=>$val){
				$new_element = $dom->createElement($key,$val);
				$staff->appendChild($new_element);
			}	
		}	
	}
	$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	return $xmlString;	
}
//---------------------------------------------------------------------
function myf_get_personalstaff_xml($funct,$db,$id){
	$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);	
	$str_query = "select staff_inform.name,staff_inform.surname,staff_inform.birth_day, staff_inform.adress,
		staff_inform.email,staff_inform.telephon,staff_inform.resume,staff_working.position,
		staff_working.enrolment_data,staff_working.reference,departament.title	from staff_inform,staff_working,departament WHERE staff_inform.id_staff='".$id."' 
		AND staff_working.id_worker = staff_inform.id_staff	AND staff_working.departament = departament.id_dep ;";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных")); } ;
	$num_rows = $result->num_rows;
	if(!$num_rows){ exit(myf_inform_xml("По вашему запросу в базе данных 
		ничего не найдено.")); }	
	for($i=0; $i<$num_rows; $i++){		
		$row = $result->fetch_assoc();
		$staff = $dom->createElement('nextStaff');
		$response->appendChild($staff);
		foreach($row as $key=>$val){
			$new_element = $dom->createElement($key,$val);
			$staff->appendChild($new_element);
		}	
	}	
	$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	return $xmlString;
}
//---------------------------------------------------------------------
function myf_get_allstaff_xml($funct,$db){
	$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);
	
	$str_query = "select * from staff_inform WHERE work='1';";
	$result = $db->query($str_query);
	if(!$result){ exit(myf_err_xml("Не удалось соединиться с Базой данных")); } ;
	$num_rows = $result->num_rows;
	if(!$num_rows){ exit(myf_inform_xml("По вашему запросу в базе данных 
		ничего не найдено.")); }	
	for($i=0; $i<$num_rows; $i++){		
		$row = $result->fetch_assoc();
		$staff = $dom->createElement('nextStaff');
		$response->appendChild($staff);
		foreach($row as $key=>$val){
			$new_element = $dom->createElement($key,$val);
			$staff->appendChild($new_element);
		}	
	}
	$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	return $xmlString;
}
function myf_err_xml($str_error){
	$dom_err = new DOMDocument();
	$error = $dom_err->createElement('error',$str_error);
	$dom_err->appendChild($error);
	$xmlErrStr = $dom_err->saveXML();
	return $xmlErrStr;
}
function myf_inform_xml($str_inform){
	$dom_inform = new DOMDocument();
	$inform = $dom_inform->createElement('underreporting',$str_inform);
	$dom_inform->appendChild($inform);
	$xmlInformStr = $dom_inform->saveXML();
	return $xmlInformStr;
}
?>