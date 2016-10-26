var structure =  document.getElementById('structure');
structure.onclick = getStructure;

function getStructure(){
	var theUrl = "PHP/structure.php";
	var theParam = "functionHandler=viewStructure";	
	setAjaxQuery(theUrl,theParam);
};
function viewStructure(responseXMLDocument){	
	addFindWindow.hidden = "";
	windowForForm.innerHTML = "<h2>Структура отделов.</h2>";
	addFindWindow.setAttribute("destiny", "structure");
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff')[0].textContent;
//	alert(nextStaff);
	var cart = JSON.parse ( nextStaff );
	alert(cart);
//	windowForForm.innerHTML = nextStaff;

};