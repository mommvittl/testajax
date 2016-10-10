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
	</nav>
	<section class="detailed_list">
	
	<div id="detailedNav"><nav class="nav">
		<span><span id="changePersonalStaff">редактировать</span></span>
		<span><span id="addPersonalStaff">добавить</span></span>
		<span><span id="deletePersonalStaff">удалить</span></span>
	</nav></div>
	<div id="detailed">
	
	</div>
	</section>
	<section class="total_list">	
	<div id="total">
	
	</div>
	</section>
	</main>
	</div>

<script src="JS/my_js_library.js"></script>	
<script src="JS/index_script.js"></script>	
<script src="JS/search_script.js"></script>	
</BODY>
</HTML>