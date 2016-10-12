//====основная======часть=======================================
var structure =  document.getElementById('structure');
structure.onclick = getStructure;
var directors =  document.getElementById('directors');
directors.onclick = getDirectors;
var departaments =  document.getElementById('departaments');
departaments.onclick = getDepartaments;
var allStaff =  document.getElementById('allStaff');
allStaff.onclick = getAllstaff;
var findStaff =  document.getElementById('findStaff');
findStaff.onclick = getFindStaff;
var changePersonalStaff =  document.getElementById('changePersonalStaff');
changePersonalStaff.onclick = getChangePersonalStaff;
var addPersonalStaff =  document.getElementById('addPersonalStaff');
addPersonalStaff.onclick = getAddPersonalStaff;
var deletePersonalStaff =  document.getElementById('deletePersonalStaff');
deletePersonalStaff.onclick = getDeletePersonalStaff;

var detailedNav = document.getElementById('detailedNav');
detailedNav.hidden = true;
var viewDetal = document.getElementById('viewDetal');
var viewAddStaff = document.getElementById('viewAddStaff');
viewAddStaff.hidden = true;

//=====DELETE===Staff======================================================


function getDeletePersonalStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDeletePersonalStaff&searchList=delete";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDeletePersonalStaff(responseXMLDocument){
	alert("viewDeletePersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//=======ADD==Staff=====================================================
function getAddPersonalStaff(){
	document.forms.formAddStaff.elements.formAddClose.onclick = function(){ viewAddStaff.hidden = true;  }
	viewAddStaff.hidden = "";
	var formAddStaff = document.forms.formAddStaff;
	formAddStaff.onsubmit = addFormSubmit;
	
//	var theUrl = "PHP/staff_list.php";
//	var theParam = "functionHandler=viewAddPersonalStaff&searchList=add";	
//	setAjaxQuery(theUrl,theParam);	
};
function addFormSubmit(){
	var theUrl = "PHP/add_staff.php";
	var theParam = "functionHandler=viewAddPersonalStaff";	
	for( var i = 0; i < document.forms.formAddStaff.elements.length; i++){
		var tagnm = document.forms.formAddStaff.elements[i].name;
		var tagdt = document.forms.formAddStaff.elements[i].value;
		theParam += "&" + tagnm + "=" + tagdt;		
	}	
	alert(theParam);
	setAjaxQuery(theUrl,theParam);
	viewAddStaff.hidden = true;
	return false;
};
function viewAddPersonalStaff(responseXMLDocument){
	viewAddStaff.hidden = "";
	alert("viewAddPersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//=====CHANGE==Staff=======================================================
function getChangePersonalStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewChangePersonalStaff&searchList=change";	
	setAjaxQuery(theUrl,theParam);	
};
function viewChangePersonalStaff(responseXMLDocument){
	alert("viewChangePersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//=======FIND===Staff====================================================
function getFindStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewFindStaff&searchList=find";	
	setAjaxQuery(theUrl,theParam);	
};
function viewFindStaff(responseXMLDocument){
	alert("viewFindStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//======GET===All===Staff==================================================
function getAllstaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewAllstaff&searchList=all";	
	setAjaxQuery(theUrl,theParam);	
};
function viewAllstaff(responseXMLDocument){

	var total = document.getElementById('total');
	total.innerHTML = "";
	var table = document.createElement('table');
	table.className = "totalTable";
	table.innerHTML = "<tr><th>фамилия</th><th>имя</th><th>адрес</th><th>телефон</th></tr>";
	total.appendChild(table);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	for (var i = 0; i < nextStaff.length; i++){
		var id = nextStaff[i].getElementsByTagName('id_staff')[0].textContent;
		var row = document.createElement('tr');
		row.className = "totalRowData";
		row.onclick = getDetaliedStaffInfo;
		row.setAttribute('idStaff', id) ;
		table.appendChild(row);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('surname')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('name')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('adress')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('telephon')[0].textContent;
		row.appendChild(td);
	}
}
//========GET===Htrsonal===Staff=============================================================================
function getDetaliedStaffInfo(){
	var id = this.getAttribute('idStaff');
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDetaliedStaffInfo&searchList=personal&id="+id;	
	setAjaxQuery(theUrl,theParam);	
};
function viewDetaliedStaffInfo(responseXMLDocument){
	detailedNav.hidden = "";
//	alert(myReq.responseText);
	var tagsName = {'name':'Имя','surname':'Фамилия','birth_day':'Дата рождения','adress':'Дом.адрес','email':'Email','telephon':'контакт.телефон','resume':'резюме','position':'Должность','enrolment_data':'Принят на роботу','reference':'Характеристика','title':'Отдел'}
	var detailed = document.getElementById('detailed');
	detailed.innerHTML = "";
	var table = document.createElement('table');
	table.className = "detailedTable";
	detailed.appendChild(table);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff')[0];
	
	for (var i = 0; i < nextStaff.childNodes.length; i++){		
		var newTag = nextStaff.childNodes[i];
		if(newTag.tagName != 'id_staff' && newTag.tagName != 'work'){
			var row = document.createElement('tr');
			row.className = "detailedRowData"; 
			table.appendChild(row);
			var td = document.createElement('td'); 
			td.textContent = tagsName[newTag.tagName];
			row.appendChild(td);
			var td = document.createElement('td'); 
			td.textContent = newTag.textContent;
			row.appendChild(td);
//			alert(newTag.tagName);
		}
		
	}
	
}
//--------------------------------------------------------------
//========GET====Departament==================================================
function getDepartaments(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDepartaments&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDepartaments(responseXMLDocument){
	alert("viewDepartaments : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//=========GET====Structure=================================================
function getStructure(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewStructure&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewStructure(responseXMLDocument){
	alert("viewStructure : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//=======GET===Director====================================================
function getDirectors(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDirectors&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDirectors(responseXMLDocument){
	alert("viewDirectors : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------



