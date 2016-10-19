//====основная======часть=======================================
var structure =  document.getElementById('structure');
structure.onclick = getStructure;
var directors =  document.getElementById('directors');
directors.onclick = getDirectors;
var departaments =  document.getElementById('departaments');
departaments.onclick = getDepartaments;
var allStaff =  document.getElementById('allStaff');
allStaff.onclick = getAllstaff;
var changePersonalStaff =  document.getElementById('changePersonalStaff');
changePersonalStaff.onclick = getChangePersonalStaff;
var deletePersonalStaff =  document.getElementById('deletePersonalStaff');
deletePersonalStaff.onclick = getDeletePersonalStaff;
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
//=====DELETE===Staff======================================================
function getDeletePersonalStaff(){
		if(document.getElementById('detailed').getAttribute("filial") != globalFilialName) { 
			dispModalInformWindow("Error...<br>Нарушение прав доступа.<br>Вы не можете уволить сотрудника не своего филиала.");
			return;	}
		if (  globalFilialName)
		var modal = document.createElement('div');  		
		modal.innerHTML = "<h1>Вы уверены, что хотите уволить сотрудника?</h1><br><br><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
		document.body.insertBefore(modal, document.body.firstChild);	
		var ok_but = document.getElementById('ok_but');
		var cancel_but = document.getElementById('cancel_but');	
		modal.style.cssText="width:700px; max-width: 100%; padding:50px 30px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);";
		ok_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
		cancel_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";			
		cancel_but.onclick = function() 
			{ document.body.removeChild(modal); };			
		ok_but.onclick = function() 
			{
			document.body.removeChild(modal);		
			var deleteStaffId = document.getElementById('detailed').getAttribute("idStaffSelect");
			var theUrl = "PHP/delete_staff.php";
			var theParam = "functionHandler=viewDeletePersonalStaff&searchList=delete&deleteStaffId=" + deleteStaffId;	
			setAjaxQuery(theUrl,theParam);
			var detailed = document.getElementById('detailed');
			detailed.innerHTML = "";
			detailedNav.hidden = true;		
			};		
};
//--------------------------------------------------------------
//=====CHANGE==Staff=======================================================
function getChangePersonalStaff(){
	
	var detailed = document.getElementById('detailed');
	var filial = detailed.getAttribute("filial");
	var id = detailed.getAttribute("idStaffSelect");
//	alert("getChangePersonalStaff " + id + " " +filial);
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewChangePersonalStaff&searchList=change&id="+id+"&filial="+filial;	
	setAjaxQuery(theUrl,theParam);	
};
function viewChangePersonalStaff(responseXMLDocument){
	addFindWindow.hidden = "";
	windowForForm.innerHTML = "";
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff')[0];
	var id = nextStaff.getElementsByTagName('id_staff')[0].textContent;
	var name = nextStaff.getElementsByTagName('name')[0].textContent;	
	var surname = nextStaff.getElementsByTagName('surname')[0].textContent;	
	var title = nextStaff.getElementsByTagName('title')[0].textContent;
	var position = nextStaff.getElementsByTagName('position')[0].textContent;	
//	alert(id+name+surname+position+title);
	windowForForm.setAttribute('idStaff', id) ;
	var div = document.createElement('div');
	div.className = "changePersonal";	
	div.innerHTML = "<hr><h1>Окно первода сотрудника.</h1><p><span>Фамилия</span><span>"+surname+"</span></p>";
	div.innerHTML +="<p><span>Имя</span><span>"+name+"</span></p>";
	div.innerHTML += "<p><span>Отдел</span><span>"+title+"</span></p>";
	div.innerHTML += "<p><span>Должность</span><span>"+position+"</span></p>";
	div.innerHTML += "<h2>Куда переводить сотрудника:</h2>";
	windowForForm.appendChild(div);
	var form = document.createElement('form');
	form.className = "changePersonal";	
	form.name = "changeFormStaff";
	form.innerHTML = "<input type='hidden' name='id_staff' value='"+id+"'></input>";
	form.innerHTML += "<p><span>Отдел</span><select name='departament'  required></select></p>"
	form.innerHTML += "<p><span>новая должность</span><input type='text' name='position'  required></input></p>";
	form.innerHTML += '<p><span>Дата первода</span><input type="date" name="discharge_data"  required></input></p>';
	form.innerHTML += "<p><input type='reset' name='butreset'></input><input type='submit' name='changeGo' value='перевести'></input></p>";		
	div.appendChild(form);
	setAjaxQuery("PHP/staff_list.php","functionHandler=changeOptionsToDepartament&searchList=optionsToSelect");		
}
function changeOptionsToDepartament(){
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var departament = document.forms.changeFormStaff.elements.departament;	
	for (var i = nextStaff.length -1; i >= 0 ; i--){
		var option = document.createElement('option');
		option.textContent = nextStaff[i].getElementsByTagName('title')[0].textContent;
		option.value = nextStaff[i].getElementsByTagName('id_dep')[0].textContent;
		departament.appendChild(option);
	}
	var changeFormStaff = document.forms.changeFormStaff;
	changeFormStaff.onsubmit = changeFormSubmit;		
}
function changeFormSubmit(){
	var theUrl = "PHP/change_staff.php";
	var id = windowForForm.getAttribute('idStaff') ;
	var theParam = "functionHandler=viewAddPersonalStaff&id_staff="+id;	
	
	for( var i = 0; i < document.forms.changeFormStaff.elements.length; i++){
		var tagnm = document.forms.changeFormStaff.elements[i].name;
		var tagdt = document.forms.changeFormStaff.elements[i].value;
		theParam += "&" + tagnm + "=" + tagdt;		
	}	
	alert(theParam);
	setAjaxQuery(theUrl,theParam);	
	addFindWindow.hidden = true;
	return false;
};
//--------------------------------------------------------------

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
	var tagsName = {'name':'Имя','surname':'Фамилия','birth_day':'Дата рождения','adress':'Дом.адрес','email':'Email','telephon':'контакт.телефон','resume':'резюме','position':'Должность','enrolment_data':'Принят на роботу','reference':'Характеристика','title':'Отдел'}
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



