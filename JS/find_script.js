var findStaff =  document.getElementById('findStaff');
findStaff.onclick = getFindStaff;
var viewFindStaff = document.getElementById('viewFindStaff');
viewFindStaff.hidden = true;

//=======FIND===Staff====================================================
function getFindStaff(){
	viewFindStaff.hidden = "";
	document.forms.formFindStaff.elements.formFindClose.onclick = function(){ viewFindStaff.hidden = true;  }
//	var theUrl = "PHP/staff_list.php";
//	var theParam = "functionHandler=viewFindStaff&searchList=find";	
//	setAjaxQuery(theUrl,theParam);	
};
function viewFindStaff(responseXMLDocument){
	alert("viewFindStaff : "+responseXMLDocument.childNodes[0].textContent);	
}
//--------------------------------------------------------------