<?php
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
//=================================================================================
//ф-я получения результата поиска и формирования из него xml документа для 
//возврата клиенту. В случае ошибок возвращает <error> или <underreporting>
//Если результат запроса есть формирует <response> - корневой тег. Отдельные
//строки запроса возвр.в тегах <nextStaff>.Внутри <nextStaff> отдельные поля
//запроса в тегах соотв. именам полей БД.Имя ф-ии обработчика на клиенте передается
//в теге <functionHandler>.Возвращает строку с XML документом для возврата.
function myf_get_staff_iftorm($funct,$db,$str_query,$fflag_er="1"){	
	$dom = new DOMDocument();
	$response = $dom->createElement('response');
	$dom->appendChild($response);	
	$result = $db->query($str_query);
	if(!$result  && $fflag_er){ return(myf_err_xml("Не удалось соединиться с Базой данных 1")); } ;
	$num_rows = $result->num_rows;
	if(!$num_rows  && $fflag_er){ return(myf_inform_xml("По вашему запросу в базе данных 
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
//---------------------------------------------------------------------------------
?>