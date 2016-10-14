<!DOCTYPE html>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-type" CONTENT="TEXT/HTML; charset=utf-8">
<TITLE>Список сотрудников</TITLE>
<link href="CSS/styles.css" rel="stylesheet"> 
</HEAD>
 <BODY>
	<div class="out_div">
	<header>
	<h1>Учет сотрудников компании MY-COMP</h1>
	<form class="globalSearch" name="globalSearch" >
	<p><input type="text" name="searchData" placeholder="фамилия сотрудника" id="ss"></input>
	<input type="submit" name="searchGo" value="search"></input></p>
	<div id="promptingWindow" class="promptingWindow"></div>
	</form>	
	</header>
	<main>
	<nav class="nav">
		<span><span id="structure">структура</span></span>
		<span><span id="directors">руководители</span></span>
		<span><span id="departaments">отделы</span></span>
		<span><span id="allStaff">все сотрудники</span></span>
		<span><span id="findStaff">найти</span></span>
		<span><span id="addPersonalStaff">добавить</span></span>
	</nav>
	<section class="detailed_list">
	<div id="viewDetal">
	<div id="detailedNav"><nav class="nav">
		<span><span id="changePersonalStaff">редактировать</span></span>
		
		<span><span id="deletePersonalStaff" class="intercep">увольнение</span></span>
	</nav></div>
	<div id="detailed">	
	</div>
	</div>
	
	</section>
	<section class="total_list">	
	<div id="total">
	
	</div>
	</section>
	
	</main>
	<div id="viewAddStaff" class="viewAddStaff">
		<form class="formAddStaff" name="formAddStaff">
		<input type="button" value="отмена" name="formAddClose"></input>
		<h2>Внесите данные нового сотрудника</h2><hr>
		<p><span>имя</span><input type="text" name="name" required></input></p>
		<p><span>фамилия</span><input type="text" name="surname" required></input></p>
		<p><span>дата рождения</span><input type="date" name="birth_day" required></input></p>
		<p><span>адрес</span><input type="text" name="adress" required></input></p>
		<p><span>Email</span><input type="email" name="email" ></input></p>
		<p><span>Телефон</span><input type="text" name="telephon" ></input></p>
		<p><span>Резюме</span><input type="text" name="resume" ></input></p>
		<p><span>Отдел</span><select name="departament" ></select></p>
		<p><span>Должность</span><input type="text" name="position" ></input></p>
		<p><span>Дата приема</span><input type="date" name="enrolment_data" ></input></p>
		<p><input type="reset" name="butreset"></input><input type="submit" name="addGo" value="Добавить"></input></p>
	</form>
	</div>
	<div id="viewFindStaff" class="viewFindStaff">
		<form class="formFindStaff" name="formFindStaff">
		<input type="button" value="отмена" name="formFindClose"></input>
		<h2>Внесите данные о сотруднике которые вы знаете</h2><hr>
		<div>
		<p><span>Укажите место поиска:</span>
		<label><input type="radio" name="arealSearch" value="home" checked></input>только у себя</label>
		<label><input type="radio" name="arealSearch" value="raund"></input>по свей компании</label></p>
		</div>
		<div>
		<p><span>имя</span><input type="text" name="name" ></input></p>
		<p><span>фамилия</span><input type="text" name="surname" ></input></p>
		<p><span>дата рождения</span><input type="date" name="birth_day" ></input></p>
		<p><span>как искать:</span>
		<label><input type="radio" name="criterionBirthData" value="before" checked></input>до этой даты</label>
		<label><input type="radio" name="criterionBirthData" value="after"></input>после этой даты</label>
		<label><input type="radio" name="criterionBirthData" value="really"></input>точно в эту дату</label></p>
		<p><span>адрес</span><input type="text" name="adress" ></input></p>
		<p><span>Email</span><input type="text" name="email" ></input></p>
		<p><span>Телефон</span><input type="text" name="telephon" ></input></p>
		<p><span>Отдел</span><select name="departament" ></select></p>
		<p><span>Должность</span><select name="position" ></select></p>
		<p><span>Дата приема</span><input type="date" name="enrolment_data" ></input></p>
		<p><span>Сотрудник принят:</span>
		<label><input type="radio" name="criterionData" value="before" checked></input>до этой даты</label>
		<label><input type="radio" name="criterionData" value="after"></input>после этой даты</label>
		<label><input type="radio" name="criterionData" value="really"></input>точно в эту дату</label></p>
		<p><span>Статус сотрудника:</span>
		<label><input type="radio" name="worked" value="worked" checked></input>работает</label>
		<label><input type="radio" name="worked" value="noworked"></input>уже уволен</label></p>
		
		<p><input type="reset" name="butreset"></input><input type="submit" name="findGo" value="найти"></input></p>
		</div>
	</form>
	</div>
	</div>  

<script src="JS/my_js_library.js"></script>	
<script src="JS/index_script.js"></script>	
<script src="JS/search_script.js"></script>	
<script src="JS/find_script.js"></script>	
</BODY>
</HTML>