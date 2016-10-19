//=====CHANGE==Staff=======================================================
var changePersonalStaff =  document.getElementById('changePersonalStaff');
changePersonalStaff.onclick = getChangePersonalStaff;

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
	addFindWindow.setAttribute("destiny", "change");
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