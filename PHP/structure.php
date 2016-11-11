<?php
header('Content-Type: text/XML');
header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); 
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate'); 
header('Pragma: no-cache');
require_once("app_config.php");
require_once("php_user_funktion.php");
$funct = trim($_GET['functionHandler']);

	
@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { 
	exit(myf_err_xml("Не удалось соединиться с Базой данных"));
}

$str_query = "select id_dep,title,director from departament ;";
$result = $db->query($str_query);
if(!$result){ return(myf_err_xml("Не удалось соединиться с Базой данных function")); } ;
$num_rows = $result->num_rows;
$departament = [];
for($i=0; $i<$num_rows; $i++){		
		list($id,$title,$director) = $result->fetch_row();
		$departament[$id] = [$title,$director];
}

$str_query = "SELECT * FROM hiererchy ;";
$result = $db->query($str_query);
if(!$result){ return(myf_err_xml("Не удалось соединиться с Базой данных function")); } ;
$num_rows = $result->num_rows;
$page = [];
for($i=0; $i<$num_rows; $i++){	
		
		list($par,$child) = $result->fetch_row();

		$page[$par] = $child;
		$dt = $par ." = ".$child;
		
}
$ier = [];
foreach($page as $key=>$val){
	if($key == $val){ $start = $key;  }
	$elem = [];
	foreach($page as $key1=>$val1){
		if (($key == $val1) && ($key1 != $val)){$elem[$key1] = $key1; }		
	}
	$ier[$key] = $elem;
}
foreach($ier as $key=>$val){
	if (!count($val)) { unset($ier[$key]); }
}
$new[$start] =  myf_three($ier,$page,$ier[$start]);
$new =  myf_view_three($new,$departament);
$str_json = json_encode($new);
$dom = new DOMDocument();
$response = $dom->createElement('response');
$dom->appendChild($response);
$staff = $dom->createElement('nextStaff',$str_json);
		$response->appendChild($staff);
$functionHandler = $dom->createElement('functionHandler',$funct);
	$response->appendChild($functionHandler);
	$xmlString = $dom->saveXML();
	exit($xmlString);	
	
//--------------------------------------------------
function myf_view_three($arr,$departament){	
	$new_el = [];	
	foreach($arr as $key=>$val){
		$nm = $departament[$key]['0'];	
		if (is_array($val)){
			$new_el[$nm] =  myf_view_three($val,$departament);
		}else{ $new_el[$nm] = $nm; }		
	}
	return $new_el;
}
//ф-я формирует дерево взаимного подчинения отделов
function myf_three($ier,$page,$arr) {
	$new_el = [];	
	foreach($arr as $key=>$val){
		if (isset($ier[$val])){
			$new_el[$val] =  myf_three($ier,$page,$ier[$val]);
		}else{ $new_el[$val] = $val; }		
	}
	return $new_el;
}
?>





