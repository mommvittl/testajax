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
?>