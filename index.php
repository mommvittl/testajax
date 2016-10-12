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
		<form class="formAddStaff" name="formAddStaff" action="PHP/add_staff.php" method="post">
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
	</div>

<script src="JS/my_js_library.js"></script>	
<script src="JS/index_script.js"></script>	
<script src="JS/search_script.js"></script>	
</BODY>
</HTML>