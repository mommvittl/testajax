var findStaff =  document.getElementById('findStaff');
findStaff.onclick = getFindStaff;
var viewFindStaff = document.getElementById('viewFindStaff');
viewFindStaff.hidden = true;

//=======FIND===Staff====================================================
function getFindStaff(){
	viewFindStaff.hidden = "";
	document.forms.formFindStaff.elements.formFindClose.onclick = function(){ viewFindStaff.hidden = true;  }
	var formFindStaff = document.forms.formFindStaff;
	formFindStaff.onsubmit = findFormSubmit;	
	setAjaxQuery("PHP/staff_list.php","functionHandler=findOptionsToDepartament&searchList=optionsToSelect");	
	//	var theUrl = "PHP/staff_list.php";
//	var theParam = "functionHandler=viewFindStaff&searchList=find";	
//	setAjaxQuery(theUrl,theParam);	
};
//Вывод опций select для отдела
function findOptionsToDepartament(){
alert("responseTexr " + myReq.responseText);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var departament = document.forms.formFindStaff.elements.departament;
	departament.innerHTML = "";
	var option = document.createElement('option');
	option.textContent = "все отделы";
	departament.appendChild(option);
	for (var i = nextStaff.length -1; i >= 0 ; i--){
		var option = document.createElement('option');
		option.textContent = nextStaff[i].getElementsByTagName('title')[0].textContent;
		option.value = nextStaff[i].getElementsByTagName('id_dep')[0].textContent;
		departament.appendChild(option);
	}
	setAjaxQuery("PHP/staff_list.php","functionHandler=findOptionsToPosition&searchList=optionsToPosition");
}
//Вывод опций select для должности
function findOptionsToPosition(){
alert("responseTexr " + myReq.responseText);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var position = document.forms.formFindStaff.elements.position;
	position.innerHTML = "";
	var option = document.createElement('option');
	option.textContent = "все должности";
	position.appendChild(option);
	for (var i = nextStaff.length -1; i >= 0 ; i--){
		var option = document.createElement('option');
		option.textContent = nextStaff[i].getElementsByTagName('position')[0].textContent;
		option.value = nextStaff[i].getElementsByTagName('position')[0].textContent;
		position.appendChild(option);
	}
}
function findFormSubmit(){
	alert("viewFindStaff : "+responseXMLDocument.childNodes[0].textContent);	
}

function viewFindStaff(responseXMLDocument){
	alert("viewFindStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------