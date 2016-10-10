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
//==============================================================


function getDeletePersonalStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDeletePersonalStaff&searchList=delete";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDeletePersonalStaff(responseXMLDocument){
	alert("viewDeletePersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
function getAddPersonalStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewAddPersonalStaff&searchList=add";	
	setAjaxQuery(theUrl,theParam);	
};
function viewAddPersonalStaff(responseXMLDocument){
	alert("viewAddPersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
function getChangePersonalStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewChangePersonalStaff&searchList=change";	
	setAjaxQuery(theUrl,theParam);	
};
function viewChangePersonalStaff(responseXMLDocument){
	alert("viewChangePersonalStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
function getFindStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewFindStaff&searchList=find";	
	setAjaxQuery(theUrl,theParam);	
};
function viewFindStaff(responseXMLDocument){
	alert("viewFindStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
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
		td.textContent = nextStaff[i].getElementsByTagName('name')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('surname')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('adress')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('telephon')[0].textContent;
		row.appendChild(td);
	}
}
//-------------------------------------------------------------
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
//==============================================================
function getDepartaments(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDepartaments&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDepartaments(responseXMLDocument){
	alert("viewDepartaments : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
function getStructure(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewStructure&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewStructure(responseXMLDocument){
	alert("viewStructure : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------
//==============================================================
function getDirectors(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDirectors&searchList=personal";	
	setAjaxQuery(theUrl,theParam);	
};
function viewDirectors(responseXMLDocument){
	alert("viewDirectors : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------



