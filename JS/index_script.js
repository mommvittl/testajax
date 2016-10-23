//====основная======часть=======================================
var structure =  document.getElementById('structure');
structure.onclick = getStructure;
var directors =  document.getElementById('directors');
directors.onclick = getDirectors;
var departaments =  document.getElementById('departaments');
departaments.onclick = getDepartaments;
var allStaff =  document.getElementById('allStaff');
allStaff.onclick = getAllstaff;

var detailedNav = document.getElementById('detailedNav');
detailedNav.hidden = true;
var viewDetal = document.getElementById('viewDetal');
var addFindWindow = document.getElementById('addFindWindow');
addFindWindow.hidden = true;
addFindWindow.setAttribute("destiny", "none");
addFindWindow.getElementsByTagName('button')[0].onclick = function(){ addFindWindow.hidden = true; }
var windowForForm = document.getElementById('windowForForm');
var globalFilialName = 'central';
var referenceStaffInfo;

//======GET===All===Staff==================================================
function getAllstaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewAllstaff&searchList=all";	
	setAjaxQuery(theUrl,theParam);	
};
function viewAllstaff(responseXMLDocument){
//	alert(myReq.responseText);
	var total = document.getElementById('total');
	total.innerHTML = "";
	var table = document.createElement('table');
	table.className = "totalTable";
	table.innerHTML = "<tr><th>фамилия</th><th>имя</th><th>адрес</th><th>телефон</th></tr>";
	total.appendChild(table);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	for (var i = 0; i < nextStaff.length; i++){
		var id = nextStaff[i].getElementsByTagName('id_staff')[0].textContent;
		var filial = nextStaff[i].getElementsByTagName('filial')[0].textContent;
		var row = document.createElement('tr');
		row.className = "totalRowData";
		row.onclick = getDetaliedStaffInfo;
		row.setAttribute('idStaff', id) ;	
		table.appendChild(row);
		row.setAttribute('filial', filial) ;	
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
//========GET===Personal===Staff=============================================================================
function getDetaliedStaffInfo(){
	var id = this.getAttribute('idStaff');
	var filial = this.getAttribute('filial');
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewDetaliedStaffInfo&searchList=personal&id="+id+"&filial="+filial;	
	setAjaxQuery(theUrl,theParam);	
};
function viewDetaliedStaffInfo(responseXMLDocument){
	detailedNav.hidden = "";
//	alert(myReq.responseText);
	var tagsName = {'name':'Имя','surname':'Фамилия','birth_day':'Дата рождения','adress':'Дом.адрес','email':'Email','telephon':'контакт.телефон','resume':'резюме','position':'Должность','enrolment_data':'Принят на должность','reference':'Характеристика','title':'Отдел'}
	var detailed = document.getElementById('detailed');
	detailed.innerHTML = "";
	var idStaffSelect = responseXMLDocument.getElementsByTagName('id_staff')[0].textContent;
	detailed.setAttribute("idStaffSelect", idStaffSelect);
	var filialStaff = responseXMLDocument.getElementsByTagName('filial')[0].textContent;
	detailed.setAttribute("filial", filialStaff);
	var p = document.createElement('p');
	p.className = "detailedFilialStaff"; 
	detailed.appendChild(p);
	p.textContent = "филиал сотрудника: " + filialStaff;
	var table = document.createElement('table');
	table.className = "detailedTable";
	detailed.appendChild(table);
	
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff')[0];	
	for (var i = 0; i < nextStaff.childNodes.length; i++){		
		var newTag = nextStaff.childNodes[i];
		if(newTag.tagName != 'id_staff' && newTag.tagName != 'work' && newTag.tagName != 'filial'){
			var row = document.createElement('tr');
			row.className = "detailedRowData"; 
			table.appendChild(row);
			var td = document.createElement('td'); 
			td.textContent = tagsName[newTag.tagName];
			row.appendChild(td);
			var td = document.createElement('td'); 
			if( newTag.tagName == 'reference' ){	
				referenceStaffInfo = newTag.textContent;
				td.innerHTML = "<button type='button' onclick='viewReferenseStaff()'>показать в окне</button>";
				td.className = "reference";
			}else{
				td.textContent = newTag.textContent;
			}
			row.appendChild(td);
		}
		
	}
	
}
function viewReferenseStaff(){
	addFindWindow.hidden = "";
	windowForForm.innerHTML = "";
	addFindWindow.setAttribute("destiny", "reference");
	var p = document.createElement('p');
	p.className = "viewReferenseStaff";
	p.textContent = referenceStaffInfo; 	
	windowForForm.appendChild(p);
};


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
function process(){
	alert("process");
	
};


