var div = document.getElementById('win');
var form = document.forms.form;
var sub = form.elements.sub;
var myReq = getXMLHttpRequest();
var myReq1 = getXMLHttpRequest();
//var myReq = new XMLHttpRequest();
div.onmouseover = getServerTime;
sub.onclick = getServer;
// ---------------------------------------------------------------
	function getServer(){
		if (myReq1.readyState == 4 || myReq1.readyState == 0){
		var name = form.elements.name.value;
		var surname = form.elements.surname.value;
//		alert("Hello Ajax"+name+surname);
		var theUrl = "name.php?"+"name=" + name + "&surname=" + surname;;
		myReq1.open("GET", theUrl, true);
		myReq1.onreadystatechange = responseName;
		myReq1.send(null);
		return false;
		}else{
			setTimeout('getServer()',1000);
		}
	};	
//------------------------------------------------------
	function responseName() {
		if (myReq1.readyState == 3){			
			document.getElementById('ms').innerHTML = "ожидаем ответ сервера";
		}
		if (myReq1.readyState == 4 ){
			if(myReq.status == 200){
				document.getElementById('message').innerHTML += myReq1.responseText;
//				alert(myReq1.responseText);
				document.getElementById('ms').innerHTML = myReq1.responseText;
//				document.getElementById('message').innerHTML = myReq1.responseText;
				
			}
			
		}
	};	
// ---------------------------------------------------------------
	function getServerTime()
		{
		
		var thePage = 'servertime.php';
		myRand = parseInt(Math.random()*999999999999999);
		var theUrl = thePage + "?rand=" + myRand;
		myReq.open("GET", theUrl, true);
		myReq.onreadystatechange = theHTTPResponse;
		myReq.send(null);
		
		};	
// ---------------------------------------------------------------

//------------------------------------------------------
	function theHTTPResponse() {
		if (myReq.readyState == 1){
			document.getElementById('win').innerHTML = '<p>состояние запроса 1</p>';
		}else if (myReq.readyState == 2){
			document.getElementById('win').innerHTML = '<p>состояние запроса 2</p>';
		}else if (myReq.readyState == 3){
			document.getElementById('win').innerHTML = '<p>состояние запроса 3</p>';
		}else if (myReq.readyState == 4){
			if(myReq.status == 200){
				document.getElementById('win').innerHTML = myReq.responseText;
				var XMLresponse  = myReq.responseXML;
				var XMLresponseElement = XMLresponse.documentElement;
				var message = XMLresponseElement.firstChild.data;
				document.getElementById('message').innerHTML = message;
			}
		}else{
			document.getElementById('win').innerHTML = '<p>сервер не отвечает</p>';
			alert("Hello getServerTime");	
			setTimeout(' theHTTPResponse()',1000);
		}
	};
// ============ Ajax =================================================
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
			alert("Error - ошибка создания обьекта XMLHttpRequest");
		}else{
			return req;	
		}			
		};
// ---------------------------------------------------------------



