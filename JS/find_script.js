var findStaff =  document.getElementById('findStaff');
findStaff.onclick = getFindStaff;

//=======FIND===Staff====================================================
function getFindStaff(){
//	alert("findStaff");
	addFindWindow.hidden = "";
	if ( addFindWindow.getAttribute('destiny') != 'find') {  
		windowForForm.innerHTML = "";
		addFindWindow.setAttribute("destiny", "find");
		var form = document.createElement('form');
		form.className = "formFindAddStaff";
		form.name = "formFindAddStaff";
		form.innerHTML = '<h2>Внесите данные о сотруднике которые вы знаете</h2><hr><p><span>Укажите место поиска:</span><label><input type="radio" name="arealSearch" value="home" checked></input>только у себя</label><label><input type="radio" name="arealSearch" value="raund"></input>по свей компании</label></p>';
		form.innerHTML += '<p><span>имя</span><input type="text" name="name" ></input></p>';
		form.innerHTML += '<p><span>фамилия</span><input type="text" name="surname" ></input></p>';
		form.innerHTML += '<p><span>дата рождения</span><input type="date" name="birth_day" ></input></p>';
		form.innerHTML += '<p><span>как искать:</span><label><input type="radio" name="criterionBirthData" value="before" checked></input>до этой даты</label><label><input type="radio" name="criterionBirthData" value="after"></input>после этой даты</label><label><input type="radio" name="criterionBirthData" value="really"></input>точно в эту дату</label></p>';
		form.innerHTML += '<p><span>адрес</span><input type="text" name="adress" ></input></p>';
		form.innerHTML += '<p><span>Email</span><input type="text" name="email" ></input></p>';
		form.innerHTML += '<p><span>Телефон</span><input type="text" name="telephon" ></input></p>';
		form.innerHTML += '<p><span>Отдел</span><select name="departament" ></select></p>';
		form.innerHTML += '<p><span>Должность</span><select name="position" ></select></p>';
		form.innerHTML += '<p><span>Дата приема</span><input type="date" name="enrolment_data" ></input></p>';
		form.innerHTML += '<p><span>Сотрудник принят:</span><label><input type="radio" name="criterionData" value="before" checked></input>до этой даты</label><label><input type="radio" name="criterionData" value="after"></input>после этой даты</label><label><input type="radio" name="criterionData" value="really"></input>точно в эту дату</label></p>';
		form.innerHTML += '<p><span>Статус сотрудника:</span><label><input type="radio" name="worked" value="worked" checked></input>работает</label><label><input type="radio" name="worked" value="noworked"></input>уже уволен</label></p>		<p><input type="reset" name="butreset"></input><input type="submit" name="findGo" value="найти"></input></p>';		
		windowForForm.appendChild(form);
	}
	var formFindAddStaff = document.forms.formFindAddStaff;
	formFindAddStaff.onsubmit = findFormSubmit;	
	setAjaxQuery("PHP/staff_list.php","functionHandler=findOptionsToDepartament&searchList=optionsToSelect");	
};
//Вывод опций select для отдела
function findOptionsToDepartament(){
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var departament = document.forms.formFindAddStaff.elements.departament;
	departament.innerHTML = "";
	var option = document.createElement('option');
	option.textContent = "все отделы";
	option.value = "0";
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
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var position = document.forms.formFindAddStaff.elements.position;
	position.innerHTML = "";
	var option = document.createElement('option');
	option.textContent = "все должности";
	option.value = "0";
	position.appendChild(option);
	for (var i = nextStaff.length -1; i >= 0 ; i--){
		var option = document.createElement('option');
		option.textContent = nextStaff[i].getElementsByTagName('position')[0].textContent;
		option.value = nextStaff[i].getElementsByTagName('position')[0].textContent;
		position.appendChild(option);
	}	
}
function findFormSubmit(){
	var theUrl = "PHP/find_staff.php";
	var theParam = "functionHandler=viewAllstaff";	
	for( var i = 0; i < document.forms.formFindAddStaff.elements.length; i++){
		var newElemForm = document.forms.formFindAddStaff.elements[i];
		if (newElemForm.type != "radio" ){theParam += "&" + newElemForm.name + "=" + newElemForm.value;}	
		if (newElemForm.type == "radio" && newElemForm.checked == true){
			theParam += "&" + newElemForm.name + "=" + newElemForm.value;
		}	
	}	
	setAjaxQuery(theUrl,theParam);
	addFindWindow.hidden = true;
	return false;
}
//--------------------------------------------------------------