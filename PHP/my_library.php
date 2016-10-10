<?php
// Ф-я разложения целых чисел по разрядам
// Возвращает массив со значениями разрядов
function myf_expansion($i)
	{
	$i = (int)$i;	
	do 
		{	
		$arr[] = $i%10;	
		$i /= 10;
		}
		while ( $i >= 1);
	return $arr;	
	}
//-----------------------------------------	
// Ф-я сборки массивацелых чисел  Возвращает целое цисло.
// Ф-я обратна к myf_expansion($i)
function myf_unexpansion($arr)
	{
	{
	$n = 1; $x=0;	
	for ($i=0;$i<count($arr);$i++)
		{	
		$x = $x + $arr[$i]*$n;	
		$n *= 10;
		}
	return $x;	
	}	
	}
//-----------------------------------------	
// ф-я для решения задачи ЛИСА+ВОЛК=ЗВЕРИ
// исп рекурсию для перебора всех вариантов 
function myf_rec($num,$array_i,$array_c)
	{		
	for ($j=0;$j<=$num;$j++)
		{
		$n = $num; $arr_i = $array_i; $arr_c = $array_c;	
		$arr_c[$n] = $arr_i[$j];
		for($m=$j;$m<=$n;$m++) { $arr_i[$m] = $arr_i[$m+1]; }	
		if ($n != 0) {  $n--; myf_rec($n,$arr_i,$arr_c); }
			else
				{
				$lisa = $arr_c[0]*1000 + $arr_c[1]*100 + $arr_c[2]*10 + $arr_c[3];
				$volk = $arr_c[4]*1000 + $arr_c[5]*100 + $arr_c[0]*10 + $arr_c[6];
				$zveri = $arr_c[7]*1000 + $arr_c[4]*100 + $arr_c[8]*10 + $arr_c[9] + $arr_c[1];
				if ($lisa+$volk == $zveri ) echo "<p>$lisa + $volk == $zveri</p>";
				}
		
		}
	}
//-------------------------------------------------------------------
// Ф-я возвращает массив номеров страниц для формирования постраничной навигации
// Элементы массива от 0 до ДЛИННА_СТРОКИ-1. индикатором  значения "..." является -1.
// На вход принимает $page - номер текущей страницы ,$max_page - мах число страниц,
// $lenght_row - к-во элементов в строке постраничной навигации
function myf_row_links($page,$max_page,$lenght_row)
	{
// проверка входных данных. Если длинна строки < 7 возврат 	false	
	if ($max_page <= $lenght_row)	
		{
		for ($i = 0; $i < $max_page; $i++)	$arr[$i] = $i+1;
		return $arr;
		}	
	if ($lenght_row < 7) $lenght_row = 7;	
	if ($page < 1) $page = 1;
	if ($page > $max_page) $page = $max_page;
// Основная часть
	$arr = array();
	$arr[0] = 1;
	$arr[$lenght_row-1] = $max_page;
// Вариант начало навигации
	if ($page < ceil($lenght_row/2)) 
		{ 
		for ($i=1; $i < ($lenght_row-2); $i++) $arr[$i] = $i+1; 
		$arr[$lenght_row-2] = -1;
		return $arr;
		}
// 	Вариант конец навигации		
	if ($page > ($max_page - ceil($lenght_row/2)))
		{
		$arr[1] = -1;
		for ($i=2; $i < ($lenght_row-1); $i++) $arr[$i] = ( $max_page+$i-$lenght_row+1);
		return $arr;
		}	
// 	Вариант середина навигации		
	$arr[1] = -1;	
	$arr[$lenght_row-2] = -1;
	for ($i=2; $i < ($lenght_row-2); $i++)	$arr[$i] = $page-floor($lenght_row/2)+$i;
	return $arr;
	}
//----------------------------------------------- 
// ф-я вывода с пом javascript всплывающего окна с сообщением
// Принимает строку для вывода.
function myf_print_error($str_err)
	{
	?>
	<script>	
	var modal_str_error = document.createElement('div');
	modal_str_error.className = "modaldiv";
	modal_str_error.innerHTML = "<h1><?php echo $str_err ?></h1><button id=\"closemodal\">OK</button></p>";
	document.body.insertBefore(modal_str_error, document.body.firstChild);	 
	var click_close_but = document.getElementById('closemodal');
	modal_str_error.style.cssText="width:600px; max-width: 100%; padding:10px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);";
	click_close_but.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";
	modal_str_error.onclick = function() {
	document.body.removeChild(modal_str_error)
	};
	</script>		
	<?php
	return;	
	}
//----------------------------------------------------------
// ф-я вывода с пом javascript всплывающего окна с сообщением
// Принимает строку для вывода. Потом перенаправляет по адресу $url_go.
function myf_print_error_go($str_err,$url_go)
	{
	echo " ";	
	?>	
	<script>	
	var modal_str_error_go = document.createElement('div');
	modal_str_error_go.className = "modaldiv";
	modal_str_error_go.innerHTML = "<h1><?php echo $str_err ?></h1><button id=\"closemodal\">OK</button></p>";
	document.body.insertBefore(modal_str_error_go, document.body.firstChild);	 
	var click_close_but_go = document.getElementById('closemodal');
	modal_str_error_go.style.cssText="width:600px; max-width: 100%; padding:10px; background:#F4A460; color:#800000; text-align:center; font: 1em/2em arial; border: 4px solid #A52A2A; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%);";
	click_close_but_go.style.cssText="border-radius:10px; padding: 10px 20px; background:#F5F5DC; cursor:pointer; outline:none; margin-left: 20px;";
	modal_str_error_go.onclick = function() {
	document.body.removeChild(modal_str_error_go);
	window.location = "<?php echo $url_go ?>";
	};
	</script>		
	<?php	
	return;	
	}
//----------------------------------------------------------
// ф-я подключения к БД. Принимает имя хоста,имя юзера,пароль доступа к БД,имя таблицы.
// Bозвращает соединение или false в случае неудачи.		
function myf_connect_BD($host,$user,$pass,$basaname)
	{
	@ $connect = mysql_connect($host,$user,$pass);
	if ( !$connect ) return false;
	if ( !mysql_select_db($basaname)) return false;  	 
	return $connect; 	
	}
//----------------------------------------------------------------------------------------
// ф-я вывода строки меню. 
// Принимает ассоциативный массив $array_menu, где ключ - название пункта, а значение - адрес, куда переходить
// и имя класса $class_name кот. будет иметь эта навигация. В таблицу стилей необходимо добавить соотв. стили:
// .class_name { display: table-row; width: 100%; text-align: justify; background: #DEB887; }
// .class_name span {width: auto; display: table-cell; text-align: center; padding: 10px; border-left: 1px solid black;}
// .class_name span:first-of-type { border-left: none;}
// .class_name span a {width: 1000px; display: table-cell; text-decoration: none; font: 1em arial; color: #A52A2A; }

function myf_disp_main_navi($array_menu,$class_name)
	{
	echo "<nav class=\"$class_name\">";
	foreach($array_menu as $key => $value)
		{ echo "<span><a href=\"$value\">$key</a></span>";   }
	echo "</nav>";	
	} 
//-----------------------------------------------------------------------------------------
// Ф-я вывода простой кнопки с простым переходом по тегу <a>
// Принимает $butt_name - надпись на кнопке , $address - адрес, куда переходить по ссылке 
// и и имя класса $class_name кот. будет иметь эта навигация. В таблицу стилей необходимо добавить соотв. стили:
//.class_name {  display: inline-block; height: 32px;  }
//.class_name a{ width: 200px; line-height: 30px; border: 1px solid #556B2F; border-radius: 15px; background: #EEE8AA; color: #556B2F;
//	text-decoration: none; display: inline-block; text-align: center; margin-top: 0; margin-bottom: 2px; box-shadow: 0 3px 0 #556B2F;}
//.class_name a:active { margin-top: 2px; margin-bottom: 0; box-shadow: 0 1px 0 #556B2F; }

function myf_disp_but_simple($butt_name,$address,$class_name)
	{
	echo "<span class=\"$class_name\"><a href=\"$address\" >$butt_name</a><span>"; 		
	}
//-------------------------------------------------------------------------------------------
// Ф-я вывода кнопки с передачей параметров с пом. скрытых полей формы.
// Принимает $butt_name - надпись на кнопке , $address - адрес перехода, class_name - имя класса,
// и $arr_param - ассоциативный массив , где ключ - имя параметра, а значение - его значение.
// .lass_name > input[type="submit"] {width: 200px; line-height: 30px; border: 1px solid #556B2F; border-radius: 15px; background: #EEE8AA; color: #556B2F;
//	box-shadow: 0 3px 0 #556B2F; text-decoration: none; display: inline-block; text-align: center; margin-top: 0; margin-bottom: 2px; outline: none;}
// .lass_name > input[type="submit"]:active { box-shadow: 0 1px 0 #556B2F; margin-top: 2px; margin-bottom: 0;}

function   myf_disp_but_parametr($butt_name,$address,$class_name,$arr_param)
	{
	echo "<form action=\"$address\" method=\"post\" class=\"$class_name\">";
	foreach($arr_param as $key => $value)
		{ echo "<input type=\"hidden\" name=\"$key\"	value=\"$value\">"; }
	echo "<input type=\"submit\" value=\"$butt_name\">";			 
	echo  "</form>";
	}










?>