var addPersonalStaff =  document.getElementById('addPersonalStaff');
addPersonalStaff.onclick = getAddPersonalStaff;

//=======ADD==Staff=====================================================
function getAddPersonalStaff(){
//  alert("getAddPersonalStaff");
	addFindWindow.hidden = "";
	if ( addFindWindow.getAttribute('destiny')!= 'add'){
		windowForForm.innerHTML = "";
		addFindWindow.setAttribute("destiny", "add");
		var form = document.createElement('form');
		form.className = "formFindAddStaff";
		form.name = "formFindAddStaff";
		form.id = "formAddTextData";
		form.innerHTML += '<h2>Внесите данные нового сотрудника</h2><hr>';
		form.innerHTML += '<p><span>имя</span><input type="text" name="name"></input></p>';
		form.innerHTML += '<p><span>фамилия</span><input type="text" name="surname"></input></p>';
		form.innerHTML += '<p><span>дата рождения</span><input type="date" name="birth_day"></input></p>';
		form.innerHTML += '<p><span>адрес</span><input type="text" name="adress"></input></p>';
		form.innerHTML += '<p><span>Email</span><input type="email" name="email" ></input></p>';
		form.innerHTML += '<p><span>Телефон</span><input type="text" name="telephon" ></input></p>';
//		form.innerHTML += '<p><span>Резюме</span><input type="text" name="resume" ></input></p>';
		form.innerHTML += '<p><span>Отдел</span><select name="departament" ></select></p>';
		form.innerHTML += '<p><span>Должность</span><input type="text" name="position" ></input></p>';
		form.innerHTML += '<p><span>Дата приема</span><input type="date" name="enrolment_data" ></input></p>';
//		form.innerHTML += '<p><input type="reset" name="butreset"></input><input type="submit" name="addGo" value="Добавить"></input></p>	';	
		windowForForm.appendChild(form);
// определение второй формы 
		var form = document.createElement('form');
		form.enctype = "multipart/form-data";
		form.action = "PHP/add_file_staff.php";
		form.method = "post";
		form.target="upload_frame";
		form.className = "formFindAddStaff";
		form.name = "formAddFileStaff";
		form.innerHTML = "<input type='hidden' name='MAX_FILE_SIZE' value='2000000' ></input>"; 
		form.innerHTML += "<input type='hidden' name='functionHandler' value='viewAddPersonalStaff' ></input>"; 
		form.innerHTML += "<input type='hidden' name='id_staff' value='' ></input>"; 
		form.innerHTML += '<p><span>Фото</span><input type="file" name="foto" ></input></p>';
		form.innerHTML += '<p><span>резюме</span><input type="file" name="resume" ></input></p>';
		form.innerHTML += '<p style="display: none"><input type="reset" name="butfilereset"></input><input type="submit" name="fileGo" value="Добавить"></input></p>	';
//	  	
		windowForForm.appendChild(form);
		var p = document.createElement('p');
		p.className = "formFindAddStaff";
		p.innerHTML = '<input type="reset" name="butreset" form="formAddTextData"></input>';
		p.innerHTML += '<input type="submit" name="addGo" value="Добавить" form="formAddTextData"></input>';
		windowForForm.appendChild(p);
	}		 
	var formFindAddStaff = document.forms.formFindAddStaff;
	formFindAddStaff.onsubmit = addFormSubmit;
		
	setAjaxQuery("PHP/staff_list.php","functionHandler=addOptionsToSelect&searchList=optionsToSelect");			
};
//вывод значений options для selecta отдел
function addOptionsToSelect(){
//	alert("addOptionsToSelect");
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
//	alert("addFormSubmit");	
	var theUrl = "PHP/add_staff.php";
	var theParam = "functionHandler=viewAddPersonalStaff";	
	for( var i = 0; i < document.forms.formFindAddStaff.elements.length; i++){
		var tagnm = document.forms.formFindAddStaff.elements[i].name;
		var tagdt = encodeURIComponent(document.forms.formFindAddStaff.elements[i].value);
		theParam += "&" + tagnm + "=" + tagdt;		
	}		
	setAjaxQuery(theUrl,theParam);
	addFindWindow.hidden = true;	
	return false;
};
//Если сотрудник добавлен в базу - пересылаем фото и резюме по присвоенному ему id
function viewAddPersonalStaff(){
//	alert("viewAddPersonalStaff id=" + id);
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var id = nextStaff[0].getElementsByTagName('id_staff')[0].textContent;
	document.forms.formAddFileStaff.elements.id_staff.value = id;
	
	var formAddFileStaff = document.forms.formAddFileStaff.elements.fileGo;	
	var event = new Event("click");
	formAddFileStaff.dispatchEvent(event);	
	dispModalInformWindow('новый сотрудник добавлен в базу дааных');
	
};
//--------------------------------------------------------------