// Модуль работы с окном поиска search в header
var searchData = document.forms.globalSearch.elements.searchData;
searchData.oninput = searchFormInputData;
searchData.setAttribute("autocomplete","off");
var promptingWindow = document.getElementById('promptingWindow');
var globalSearch = document.forms.globalSearch;
globalSearch.onsubmit = searchFormSubmit;
promptingWindow.hidden = true;

//----------------------------------------------------------
function searchFormInputData(){
//	promptingWindow.hidden = "";	
	var searchDataValue = searchData.value;
	if (searchDataValue.length > 0){
		var theUrl = "PHP/staff_list.php";
		var theParam = "functionHandler=viewSearchPrompting&searchList=prompting&searchValue=" + searchDataValue;	
		setAjaxQuery(theUrl,theParam);
	}
}
//-----------------------------------------------------------------
function viewSearchPrompting(responseXMLDocument){
	promptingWindow.innerHTML = "";	
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	if(nextStaff.length > 0) { promptingWindow.hidden = ""; };
	for (var i = 0; i < nextStaff.length; i++){
		var id = nextStaff[i].getElementsByTagName('id_staff')[0].textContent;
		var staffName = nextStaff[i].getElementsByTagName('name')[0].textContent;
		var staffSurname = nextStaff[i].getElementsByTagName('surname')[0].textContent;
		var row = document.createElement('p');
		row.className = "promptingRow";
		row.textContent = staffSurname + " " + staffName;
		row.onclick = getDetaliedPromptingInfo;
		row.setAttribute('idStaff', id) ;
		promptingWindow.appendChild(row);		
	}
}
//------------------------------------------------------------------
function getDetaliedPromptingInfo(){
	promptingWindow.hidden = true;
	searchData.value = "";
	var id = this.getAttribute('idStaff');
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDetaliedStaffInfo&searchList=personal&id="+id;	
	setAjaxQuery(theUrl,theParam);	
};
//-----------------------------------------------------------------
function searchFormSubmit(){
	promptingWindow.hidden = true;
	var searchDataValue = searchData.value;
	searchData.value = "";	
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewAllstaff&searchList=searchl&surnameSearch="+searchDataValue;	
	setAjaxQuery(theUrl,theParam);		
	return false;
}
//---------------------------------------------------------------------


