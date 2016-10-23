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
//проверка наличия переданного id в БД. Возврат true/false
function myf_search_id($db,$id_staff){
	$str_query = "select count(*) from staff_inform WHERE work='1' AND id_staff='".$id_staff."' ;";
	$result = $db->query($str_query);
	list($col) = $result->fetch_row();
	return ($col)?true:false;
}
//ф-я занесения изменений в записи базы дааных
//возвращает true/false
function myf_update_data($db,$str_query){
	$result = $db->query($str_query);
	return ($result)?true:false;
}
//-------------------------------------------------
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
	if(!$result  && $fflag_er){ return(myf_err_xml("Не удалось соединиться с Базой данных function")); } ;
	$num_rows = $result->num_rows;
	if(!$num_rows  && $fflag_er){ return(myf_inform_xml("По вашему запросу в базе данных 
		ничего не найдено.")); }	
	for($i=0; $i<$num_rows; $i++){		
		$row = $result->fetch_assoc();
		$staff = $dom->createElement('nextStaff');
		$response->appendChild($staff);
		$filial = $dom->createElement('filial','central');
		$staff->appendChild($filial);
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
//===================================================================================
// $result = get_web_page( $url,$parametr,$uagent );
//Ф-я посылает GET запрос на адрес $url.$parametr -  строка подготовленных параметров.
//$uagent - необязательный адрес вызывающей стр.
//Возвращает массив информации о последней операции. В массиве
// $result['errno'] - код ошибки или 0 если все Ок.
// $result['http_code'] - Последний полученный код HTTP.
// $result['errmsg'] - строка с описанием последней ошибки
// $result['content'] - контент, возвращенный по запросу 
function get_web_page( $url,$parametr,$uagent = "none" ){
  	if (strlen($parametr) >= 3 ) { $url .= "?" . $parametr; }	
	$ch = curl_init( $url );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
	curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
	curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
	curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
	$content = curl_exec( $ch ); 
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}
//------------------------------------------------------------------------------------------------//===================================================================================
// $result = get_web_page( $url,$parametr,$uagent );
//Ф-я посылает POST запрос на адрес $url.$parametr -  строка подготовленных параметров.
//$uagent - необязательный адрес вызывающей стр.
//Возвращает массив информации о последней операции. В массиве
// $result['errno'] - код ошибки или 0 если все Ок.
// $result['http_code'] - Последний полученный код HTTP.
// $result['errmsg'] - строка с описанием последней ошибки
// $result['content'] - контент, возвращенный по запросу 
function get_web_page_post( $url,$parametr,$uagent = "none",$headers = false ){
	$ch = curl_init( $url );
	if ($headers){ curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);} // Добавляем массив заголовков
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
	curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
	curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
	curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $parametr);
	$content = curl_exec( $ch ); 
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}
//------------------------------------------------------------------------------------------------
?>