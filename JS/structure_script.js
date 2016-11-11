var structure =  document.getElementById('structure');
structure.onclick = getStructure;

function getStructure(){
	var theUrl = "PHP/structure.php";
	var theParam = "functionHandler=viewStructure";	
	setAjaxQuery(theUrl,theParam);
};
function viewStructure(responseXMLDocument){
	var addFindWindow =  document.getElementById('addFindWindow');
	var windowForForm =  document.getElementById('windowForForm');
	addFindWindow.hidden = "";
	windowForForm.innerHTML = "<h2>Структура отделов.</h2>";
	addFindWindow.setAttribute("destiny", "structure");
	var nextStaff = responseXMLDocument.getElementsByTagName('nextStaff')[0].textContent;
	var cart = JSON.parse( nextStaff );
	var ul = document.createElement('ol');
	ul.className = "structureUlout";
	windowForForm.appendChild(ul);
	recursia(cart,ul,0);
};
function recursia(object,html,level){
	var newLevel = level + 1;
	var fontSize = 2.6 - 0.5 * level;
	for(var elem in object){
		var element = object[elem];
		var li = document.createElement('li');		
		li.className = "structureLi";
		li.style.cssText = "font-size: " + fontSize + "rem;";
		li.textContent = elem;
		html.appendChild(li);
//		alert(level + " font-size: " + fontSize + "rem;");		
		if(element.length === undefined){
			var ul = document.createElement('ol');
			ul.className = "structureUlin";
			li.appendChild(ul);
			recursia(element,ul,newLevel);
		}
	}	
	return true;
};