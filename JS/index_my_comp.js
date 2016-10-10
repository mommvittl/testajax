var myReq = getXMLHttpRequest();
var butallstaff =  document.getElementById('all_staff');
butallstaff.onclick = getAllStaff;
//alert("Hello");

//--------------------------------------------------------------------
function personalData(){
	personId = this.firstChild.textContent;
	var theUrl = "PHP/staff_list.php";
	var theParam = "staffId=" + personId;
	var theHanding = viewPersonalList;	
//	alert(theParam);
	setQuery(theUrl,theParam,theHanding);
};
//--------------------------------------------------------------------
function viewPersonalList(){
	if(myReq.readyState == 4 ){
		if(myReq.status == 200){
			alert(myReq.responseText);
			var addXMLData = myReq.responseXML;
			if (!addXMLData || !addXMLData.documentElement) {
				alert("Неверная структура XML.")
			}
			firstNodeName = addXMLData.childNodes[0];
			if(firstNodeName.tagName != 'response'){
				alert("ошибка - нет данных");
			}
			var menuSetup = { name: "имя сотрудника", data: "дата рождения", telephon: "телефон" };
			
			var detailed = document.getElementById('detailed');
			detailed.innerHTML = "";
			for(var i = 0; i < firstNodeName.childNodes.length; i++){
//				alert(firstNodeName.childNodes[i].textContent);
				var p  = document.createElement('p');
				detailed.appendChild(p);
				p.className = "detaliedstring";
				var span = document.createElement('span');
				span.textContent = menuSetup[firstNodeName.childNodes[i].tagName];
				p.appendChild(span);
				span = document.createElement('span');
				span.textContent = firstNodeName.childNodes[i].textContent;
				p.appendChild(span);
			}			
		}
	}	
};
//--------------------------------------------------------------------
function getAllStaff(){
	var theUrl = "PHP/staff_list.php";
	var theParam = "staffId=all";
	var theHanding = viewAllList;	
	setQuery(theUrl,theParam,theHanding);
};
//--------
function setQuery(theUrl,theParam,theHanding){
	if(myReq){
		if(myReq.readyState == 4 || myReq.readyState == 0){
			myReq.open("POST",theUrl,true);
			myReq.onreadystatechange = theHanding;
			myReq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			myReq.setRequestHeader("Content-length",theParam.length);
			myReq.setRequestHeader("Connection","close");
			myReq.send(theParam);
			
		}else{
			setTimeout('getAllStaff()',1000);	
		}
	}else{
		alert("Error - ошибка 2 создания обьекта XMLHttpRequest");
	};	
};
//--------
function viewAllList(){	
	if(myReq.readyState == 4 ){
		if(myReq.status == 200){
//			alert(myReq.responseText);
			var addXMLData = myReq.responseXML;
			if (!addXMLData || !addXMLData.documentElement) {
				alert("Неверная структура XML.")
			}
			var total = document.getElementById('total');
			total.innerHTML = "";
			var nameArray = addXMLData.getElementsByTagName('name');
			var table = document.createElement('table');
			total.appendChild(table);
			table.className = "tableclass";		
			var tbody = document.createElement('TBODY');
			table.appendChild(tbody);
			tbody.innerHTML = '<tr><th>id</th><th>name</th><th>data</th></tr>';
			for(var i = 0; i < nameArray.length; i++){
//				alert(nameArray[i].textContent  );
				var tr = document.createElement('tr');
				tr.className = "trclass";
				tr.onclick = personalData;
				tbody.appendChild(tr);
				var td = document.createElement('td');
				td.textContent =   i;
				tr.appendChild(td);
				var td = document.createElement('td');
				td.textContent = nameArray[i].textContent;
				tr.appendChild(td);
				var td = document.createElement('td');
				td.textContent = "data-data";
				tr.appendChild(td);
			}	
		}
	}	
};	
// ===== Ajax ===создание===обьекта====XMLHttpRequest===========
	function getXMLHttpRequest()
		{
		var req;
		if(window.ActiveXObject){
			try{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				req = false;
			}
		}else{
			try{
				req = new XMLHttpRequest();
			}
			catch (e){
				req = false;
			}
		}
		if( !req ){
			alert("Error - ошибка  1 создания обьекта XMLHttpRequest");
		}else{
			return req;	
		}			
		};
// ---------------------------------------------------------------



