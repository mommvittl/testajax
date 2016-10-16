var addPersonalStaff =  document.getElementById('addPersonalStaff');
addPersonalStaff.onclick = getAddPersonalStaff;

//=======ADD==Staff=====================================================
function getAddPersonalStaff(){
//	alert("getAddPersonalStaff");
	addFindWindow.hidden = "";
	if ( addFindWindow.getAttribute('destiny')!= 'add'){
		windowForForm.innerHTML = "";
		addFindWindow.setAttribute("destiny", "add");
		var form = document.createElement('form');
		form.className = "formFindAddStaff";
		form.name = "formFindAddStaff";
		form.innerHTML = '<h2>Внесите данные нового сотрудника</h2><hr>';
		form.innerHTML += '<p><span>имя</span><input type="text" name="name" required></input></p>';
		form.innerHTML += '<p><span>фамилия</span><input type="text" name="surname" required></input></p>';
		form.innerHTML += '<p><span>дата рождения</span><input type="date" name="birth_day" required></input></p>';
		form.innerHTML += '<p><span>адрес</span><input type="text" name="adress" required></input></p>';
		form.innerHTML += '<p><span>Email</span><input type="email" name="email" ></input></p>';
		form.innerHTML += '<p><span>Телефон</span><input type="text" name="telephon" ></input></p>';
		form.innerHTML += '<p><span>Резюме</span><input type="text" name="resume" ></input></p>';
		form.innerHTML += '<p><span>Отдел</span><select name="departament" ></select></p>';
		form.innerHTML += '<p><span>Должность</span><input type="text" name="position" ></input></p>';
		form.innerHTML += '<p><span>Дата приема</span><input type="date" name="enrolment_data" ></input></p>';
		form.innerHTML += '<p><input type="reset" name="butreset"></input><input type="submit" name="addGo" value="Добавить"></input></p>	';		
		windowForForm.appendChild(form);
	}		
	var formFindAddStaff = document.forms.formFindAddStaff;
	formFindAddStaff.onsubmit = addFormSubmit;
	setAjaxQuery("PHP/staff_list.php","functionHandler=addOptionsToSelect&searchList=optionsToSelect");			
};
//вывод значений options для selecta отдел
function addOptionsToSelect(){
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var departament = document.forms.formFindAddStaff.elements.departament;
	departament.innerHTML = "";
	for (var i = nextStaff.length -1; i >= 0 ; i--){
		var option = document.createElement('option');
		option.textContent = nextStaff[i].getElementsByTagName('title')[0].textContent;
		option.value = nextStaff[i].getElementsByTagName('id_dep')[0].textContent;
		departament.appendChild(option);
	}
}//Передача введеных в форму значений на обработку на сервер
function addFormSubmit(){
	var theUrl = "PHP/add_staff.php";
	var theParam = "functionHandler=viewAddPersonalStaff";	
	for( var i = 0; i < document.forms.formFindAddStaff.elements.length; i++){
		var tagnm = document.forms.formFindAddStaff.elements[i].name;
		var tagdt = document.forms.formFindAddStaff.elements[i].value;
		theParam += "&" + tagnm + "=" + tagdt;		
	}	
	setAjaxQuery(theUrl,theParam);
	addFindWindow.hidden = true;
	return false;
};
//--------------------------------------------------------------