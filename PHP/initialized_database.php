<?php
require_once("app_config.php");
@ $db = new mysqli(HOST_NAME,USER_NAME,PASSWORD_NAME,DATABASE_NAME);
if (mysqli_connect_errno()) { exit("Error...Не удалось подключиться к базе данных."); }
echo "<h1>Подключение к баз данных staff_info.</h1>";
/*
$id = 'NULL';
$name = 'first';
$surname = 'boss';
$birth_day = '1974-09-23';
$adress = 'London, dauning str. 12';
$email = 'email@com.ua';
$telephon = '12-12-12-12';
$resume =  'NULL';
*/
$str_query = "insert into staff_inform values(?,?,?,?,?,?,?,?)";
$query = $db->prepare($str_query);
$query->bind_param("isssssss",$id,$name,$surname,$birth_day,$adress,$email,$telephon,$resume);
$query->execute();
$query->close();

echo "<p>Ok данные добавлены</p>";

$db->close();
?>