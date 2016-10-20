<?php
require_once("app_config.php");
require_once("php_user_funktion.php");
$id_staff = (int)$_POST['id_staff'];
$file_type1 = ['image/gif','image/jpeg','image/pjpeg','image/png'];
$file_type2 = ['text/plain','application/msword','application/pdf'];

@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { exit(myf_err_xml("Не удалось соединиться с Базой данных для загрузки файлов")); }
//проверяем наличие такого id в базе		
if (!myf_search_id($db,$id_staff)) { exit(myf_inform_xml("Проверьте правильность вводимых данных.<br>Такого сотрудника нет в базе."));  }
//копируем файлы и сохраняем результат в базе	
	$new_file_name1 = myf_load_staff_file('foto','../STAFF_FOTO',$file_type1);
if ($new_file_name1){
	$str_query = "UPDATE staff_inform SET foto='".$new_file_name1."' WHERE id_staff='".$id_staff."' ;";
	$result1 =  myf_update_data($db,$str_query);
}
$new_file_name2 = myf_load_staff_file('resume','../STAFF_RESUME',$file_type2);
if ($new_file_name2){
	$str_query = "UPDATE staff_inform SET resume='".$new_file_name2."' WHERE id_staff='".$id_staff."' ;";
	$result2 =  myf_update_data($db,$str_query);
}
//Вывод результата браузеру
$str = "Новый сотрудник добавлен в базу.<br>";
if($result1) { $str .= 'Фото сотрудника добавлено.<br>'; }
	else {  $str .= 'Фото сотрудника добавить не удалось.<br>';   }
if($result2) { $str .= 'Резюме сотрудника добавлено.<br>'; }
	else {  $str .= 'Резюме сотрудника добавить не удалось.<br>';   }
echo $str;
//Ф-я загружает файл $file_name из формы в каталог $catalog_name
//проверяя соответствие типам переданным в необязат.массиве $file_type
//возвращает имя,под кот.файл загружен в каталог или false.
function myf_load_staff_file($file_name,$catalog_name,$file_type=[]){	
	if ($_FILES[$file_name]['error'] > 0) { return false; }	
	if ( count($file_type )){
		if ( !in_array($_FILES[$file_name]['type'],$file_type) ){  return false;     }
	}
	$new_file_name = time().mysql_escape_string( $_FILES[$file_name]['name'] );
	$upfile = $catalog_name.'/'.$new_file_name;
	if(is_uploaded_file($_FILES[$file_name]['tmp_name'])){
		if( !move_uploaded_file($_FILES[$file_name]['tmp_name'],$upfile) ){ return false;    }
	}
	return $new_file_name;	
}
?>