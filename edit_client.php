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

require_once "connect_db.php";//подключение скрипта
$table_Last_user="SELECT * FROM Lastuser";
$out1=$pdo->query($table_Last_user);
$vivod=$out1->fetchAll();
foreach ($vivod as $value)
{
        $id=$value['id'];
        $fam=$value['Surname'];
        $nam=$value['Imya'];
        $otc=$value['Otchestvo'];
        $birt=$value['Birthday'];
        $tel1=$value['Phone1'];
        $tel2=$value['Phone2'];
}

if(isset($_REQUEST['update'])){//если нажта кнопка "Сохранить изменения

    date_default_timezone_set("Europe/Moscow");//выставление времени и даты по Мск

    //получение обновленных данных с формы
    $familia=$_REQUEST['fam'];
    $Imya=$_REQUEST['nam'];
    $Otchest=$_REQUEST['otch'];
    $Birthday=$_REQUEST['birthday'];
    $Pol=$_REQUEST['sex'];
    $Telephone1=$_REQUEST['phone1'];
    $Telephone2=$_REQUEST['phone2'];
    $identificator=$id;

    //выставление даты и времени

    $date1_create=date("Y-m-d");//Дата
    $date2_create=date("H:i:s");//Время
    $date=$date1_create." ".$date2_create;//дата и время в одну переменную

    //SQL запрос по обновлению конкретных значений таблицы users
    $table = "UPDATE users SET 
    Surname =:surname,
    Imya =:namee,
    Otchestvo =:otches,
    Birthday =:birth,
    Sex=:pol,
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
    $users->bindParam(':pol', $Pol, PDO::PARAM_STR);
    $users->bindParam(':ph1', $Telephone1, PDO::PARAM_STR);
    $users->bindParam(':ph2', $Telephone2, PDO::PARAM_STR);
    $users->bindParam(':userid'  , $identificator, PDO::PARAM_STR);
    $users->execute(); //Запускает подготовленные запросы bindParam на выполнение

    header("Refresh: 2; url=index.html");//Перенаправление на главную страницу через 2 ескунды
    echo"<div class=addclient><center><br><h1>Данные клиента изменены!</h1><br><h2><i>Ожидайте, производится перенаправление</i></h2></center></div>";
}
?>


</body>
</html>
