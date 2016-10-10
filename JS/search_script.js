// Модуль работы с окном поиска search в header
var searchData = document.forms.globalSearch.elements.searchData;
searchData.oninput = searchFormInputData;
searchData.setAttribute("autocomplete","off");
var promptingWindow = document.getElementById('promptingWindow');
var globalSearch = document.forms.globalSearch;
globalSearch.onsubmit = searchFormSubmit;
promptingWindow.hidden = true;

function searchFormInputData(){
	promptingWindow.hidden = "";
	document.getElementById('promptingWindow').innerHTML = searchData.value;
	
}
function searchFormSubmit(){
//	document.getElementById('result').innerHTML = searchData.value;
	promptingWindow.hidden = true;
	alert("submit");
	return false;
}



