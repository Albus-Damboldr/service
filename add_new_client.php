<?php
/** Данный скрипт добавляет нового клиента в базу*/

//подключение скрипта для соединения с БД
require_once "connect_db.php";
/** Создание таблицы users в БД если таковой несуществует*/

$table="CREATE TABLE IF NOT EXISTS Users(
id INT NOT NULL AUTO_INCREMENT,
Surname TINYTEXT NOT NULL,
Imya TINYTEXT NOT NULL,
Otchestvo TINYTEXT NOT NULL,
Birthday TINYTEXT NOT NULL,
Sex TINYTEXT NOT NULL,
Date_Create TINYTEXT NOT NULL,
Date_Update TINYTEXT NOT NULL,
Phone1 TINYTEXT NOT NULL,
Phone2 TINYTEXT,
PRIMARY KEY (id))";
$create_table=$pdo->exec($table);//выполнение SQL запроса

//обращение к таблице users
$query="SELECT * FROM Users";

date_default_timezone_set("Europe/Moscow");//выставление времени и даты по Мск

/** Получение параметров с формы страница add_client.html**/
$fam=$_REQUEST['fam'];
$nam=$_REQUEST['nam'];
$otch=$_REQUEST['otch'];
$birth=$_REQUEST['birthday'];
$Sex=$_REQUEST['sex'];
$tel1=$_REQUEST['phone1'];
$tel2=$_REQUEST['phone2'];

$date1_create=date("Y-m-d");//Дата
$date2_create=date("H:i:s");//Время

/** Получение текущей размерности таблицы, чтобы добавить нового клиента с последующем id*/
$y="SELECT id FROM Users ORDER BY id DESC LIMIT 1";
$x=$pdo->query($y);
$z=$x->fetchColumn();
$z++;

/** Добавление в таблицу users полученые поля с формы*/

$add_to_table="INSERT INTO Users VALUES (:id,:sur,:nam,:otch,:birth,:sex,:date_create,:date_update,:ph1,:ph2)";
$string=$pdo->prepare($add_to_table);
if(!is_null($tel2)) {
    $string->execute(['id'=>$z,'sur' => $fam, 'nam' => $nam, 'otch' => $otch, 'birth' => $birth, 'sex' => $Sex, 'date_create' => $date1_create."  ".$date2_create, 'date_update' => "", 'ph1' => $tel1,'ph2'=>$tel2]);
}
else {
    $string->execute(['id'=>$z,'sur' => $fam, 'nam' => $nam, 'otch' => $otch, 'birth' => $birth, 'sex' => $Sex, 'date_create' => $date1_create."  ".$date2_create, 'date_update' => "", 'ph1' => $tel1,'ph2'=>""]);
}
header("Refresh: 2; url=index.html");//Перенаправление на главную страницу через 2 секунды
echo "<link rel='stylesheet' href='main.css'><html><body><div class=addclient><center><br><h1>Успешное добавление!</h1><br><h2><i>Ожидайте, производится перенаправление</i></h2></center></div></body></html>";
?>