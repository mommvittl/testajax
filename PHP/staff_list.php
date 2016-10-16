<?php
header('Content-Type: text/XML');
require_once("app_config.php");
require_once("php_user_funktion.php");

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}
$funct = trim($_POST['functionHandler']);
$searchList = trim($_POST['searchList']);
$funct = $db->real_escape_string($funct);
$searchList = $db->real_escape_string($searchList);
 
switch ($searchList){
	case 'all':
		$str_query = "select * from staff_inform WHERE work='1' order by surname;";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);
		break;
	case 'personal':
		$id = (int)trim($_POST['id']);
		$str_query = "select staff_inform.id_staff,staff_inform.name,staff_inform.surname,staff_inform.birth_day, staff_inform.adress,
		staff_inform.email,staff_inform.telephon,staff_inform.resume,staff_working.position,
		staff_working.enrolment_data,staff_working.reference,departament.title	from staff_inform,staff_working,departament WHERE staff_inform.id_staff='".$id."' 
		AND staff_working.id_worker = staff_inform.id_staff	AND staff_working.departament = departament.id_dep ;";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);	
		break;	
	case 'prompting':
		$searchValue = trim($_POST['searchValue']);
		$searchValue = $db->real_escape_string($searchValue);
		$str_query = "select id_staff,surname,name from staff_inform WHERE work='1' AND surname like('".$searchValue."%');";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query,false);
		break;	
		case 'search':
		$surnameSearch = trim($_POST['surnameSearch']);
		$surnameSearch = $db->real_escape_string($surnameSearch);
		$str_query = "select * from staff_inform WHERE work='1' AND surname like('".$surnameSearch."%');";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);
		break;			
	case 'optionsToSelect':
		$str_query = "select id_dep,title from departament ;";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);
		break;
	case 'optionsToPosition':
		$str_query = "select DISTINCT position from staff_working ;";
		$xmlString = myf_get_staff_iftorm($funct,$db,$str_query);
		break;	
	default :
		$xmlString = myf_inform_xml("Неопределенный запрос. Нужно подготовить
			соответствующую функцию обработки...");
		break;
}
exit($xmlString);
?>