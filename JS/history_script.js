var historyPersonalStaff =  document.getElementById('historyPersonalStaff');
historyPersonalStaff.onclick = getHistoryPersonalStaff;

function getHistoryPersonalStaff(){
	var id = detailed.getAttribute('idStaffSelect');
	var filial = detailed.getAttribute('filial');	
	var theUrl = "PHP/staff_list.php";
	var theParam = "functionHandler=viewHistoryPersonalStaff&searchList=history&id="+id+"&filial="+filial;	
//	alert("gethistoryPersonalStaff " + theParam);
	setAjaxQuery(theUrl,theParam);
};
function viewHistoryPersonalStaff(responseXMLDocument){
//	alert(surname+" response: "+myReq.responseText);
	addFindWindow.hidden = "";
	
	addFindWindow.setAttribute("destiny", "history");
	var name = responseXMLDocument.getElementsByTagName('name')[0].textContent;
	var surname = responseXMLDocument.getElementsByTagName('surname')[0].textContent;
	windowForForm.innerHTML = "<hr><h1>Страница внутренних перемещений сотрудника</h1>";
	windowForForm.innerHTML += "<h2>"+name+" "+surname+"</h2>";		
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff');
	var table = document.createElement('table');
	table.className = "totalTable";
	table.innerHTML = "<tr><th>Дата зачисления</th><th>отдел</th><th>должность</th><th>уволен/перемещен</th></tr>";
	windowForForm.appendChild(table);
	for (var i = 0; i < nextStaff.length; i++){
		var row = document.createElement('tr');
		row.className = "totalRowData";
		table.appendChild(row);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('enrolment_data')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('title')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('position')[0].textContent;
		row.appendChild(td);
		var td = document.createElement('td'); 
		td.textContent = nextStaff[i].getElementsByTagName('discharge_data')[0].textContent;
		row.appendChild(td);
	}
};