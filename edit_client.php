<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактирование клиента</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php
/** Данный Скрипт редактирует клиента и обновляет содержимое в таблице users БД*/

session_start();//Старт сессии
require_once "connect_db.php";//подключение скрипта
//Если не нажата кнопка
if(!isset($_REQUEST['update'])) {
    //то выводим форму, которая заполнена значениями сессионых переменных из предыдущего скрипта
    echo "
<center>
<h1>Редактирование клиента</h1>
    <br>
<form action='edit_client.php' method='post' style='font-size: 25px'>
    Фамилия:  <input type='text'  value='$_SESSION[fam]' name='fam' style='font-size: 20px;border-radius: 10px' required><br><br>
    Имя:      <input type='text'  value='$_SESSION[nam]' name='nam' style='font-size: 20px;border-radius: 10px' required><br><br>
    Отчество: <input type='text'  value='$_SESSION[otc]' name='otch' style='font-size: 20px;border-radius: 10px' required><br><br>
    Дата рождения: <input type='date' value='$_SESSION[bir]' name='birthday' required style='font-size: 20px;border-radius: 10px'><br><br>
    Сотовый: +7 <input type='text' value='$_SESSION[tel1]' name='phone1' style='font-size: 20px;border-radius: 10px' required><br><br>
    Рабочий (при наличии): +7 <input type='text' value='$_SESSION[tel2]' name='phone2' style='font-size: 20px;border-radius: 10px'><br><br>
   <input type='submit' value='Сохранить изменения' name='update' style='font-size: 20px;border-radius: 4px;cursor: pointer'>

</form>
    <br><br>
</center>
<!-- Данная ссылка ( в виде кнопки из-за класса в main.css ) видна на всех страницах приложения, кроме главной.
Благодаря ей пользователь может всегда вернуться в главное меню-->
<div style=\"position: fixed; left: 0;bottom: 0; padding-left: 20px;padding-bottom: 20px\">
    <a href=\"index.html\" class=\"mainbutton\">На главную</a>
</div>";
}
else if(isset($_REQUEST['update'])){//если нажта кнопка "Сохранить изменения

    date_default_timezone_set("Europe/Moscow");//выставление времени и даты по Мск

    //получение обновленных данных с формы
    $familia=$_REQUEST['fam'];
    $Imya=$_REQUEST['nam'];
    $Otchest=$_REQUEST['otch'];
    $Birthday=$_REQUEST['birthday'];
    $Telephone1=$_REQUEST['phone1'];
    $Telephone2=$_REQUEST['phone2'];
    $identificator=$_SESSION['id_clienta'];

    //выставление даты и времени

    $date1_create=date("Y-m-d");//Дата
    $date2_create=date("H:i:s");//Время
    $date=$date1_create." ".$date2_create;//дата и время в одну переменную

    //SQL запрос по обновлению конкретных значений таблицы users
    $table = "UPDATE Users SET 
    Surname =:surname,
    Imya =:namee,
    Otchestvo =:otches,
    Birthday =:birth,
    Date_Update =:datas,
    Phone1 =:ph1,
    Phone2 =:ph2
    WHERE id =:userid";

    $users = $pdo->prepare($table);//Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
    //Привязка параметра запросов к переменным
    $users ->bindParam(':surname', $familia, PDO::PARAM_STR);
    $users->bindParam(':namee', $Imya, PDO::PARAM_STR);
    $users->bindParam(':otches', $Otchest, PDO::PARAM_STR);
    $users->bindParam(':birth', $Birthday, PDO::PARAM_STR);
    $users->bindParam(':datas', $date, PDO::PARAM_STR);
    $users->bindParam(':ph1', $Telephone1, PDO::PARAM_STR);
    $users->bindParam(':ph2', $Telephone2, PDO::PARAM_STR);
    $users->bindParam(':userid'  , $identificator, PDO::PARAM_STR);
    $users->execute(); //Запускает подготовленные запросы bindParam на выполнение

    $_SESSION=array();//очистка массива сессионных переменных
    //уничтожение сессии
    session_unset();
    session_destroy();

    header("Refresh: 2; url=index.html");//Перенаправление на главную страницу через 2 ескунды
    echo"<div class=addclient><center><br><h1>Данные клиента изменены!</h1><br><h2><i>Ожидайте, производится перенаправление</i></h2></center></div>";
}
?>


</body>
</html>
