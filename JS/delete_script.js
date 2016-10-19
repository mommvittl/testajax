//=====DELETE===Staff======================================================
var deletePersonalStaff =  document.getElementById('deletePersonalStaff');
deletePersonalStaff.onclick = getDeletePersonalStaff;

function getDeletePersonalStaff(){
		if(document.getElementById('detailed').getAttribute("filial") != globalFilialName) { 
			dispModalInformWindow("Error...<br>Нарушение прав доступа.<br>Вы не можете уволить сотрудника не своего филиала.");
			return;	}
		if (  globalFilialName)
		var modal = document.createElement('div');  		
		modal.innerHTML = "<h1>Вы уверены, что хотите уволить сотрудника?</h1><br><br><button id=\"ok_but\">OK</button><button id=\"cancel_but\" autofocus>Cancel</button></p>";
		document.body.insertBefore(modal, document.body.firstChild);	
		var ok_but = document.getElementById('ok_but');
		var cancel_but = document.getElementById('cancel_but');	
		modal.style.cssText="width:700px; max-width: 100%; padding:50px 30px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);";
		ok_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#FFE4E1; cursor:pointer; outline:none; margin-right: 20px;";
		cancel_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";			
		cancel_but.onclick = function() 
			{ document.body.removeChild(modal); };			
		ok_but.onclick = function() 
			{
			document.body.removeChild(modal);		
			var deleteStaffId = document.getElementById('detailed').getAttribute("idStaffSelect");
			var theUrl = "PHP/delete_staff.php";
			var theParam = "functionHandler=viewDeletePersonalStaff&searchList=delete&deleteStaffId=" + deleteStaffId;	
			setAjaxQuery(theUrl,theParam);
			var detailed = document.getElementById('detailed');
			detailed.innerHTML = "";
			detailedNav.hidden = true;		
			};		
};
//--------------------------------------------------------------