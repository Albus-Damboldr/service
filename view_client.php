<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Карточка клиента</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php
/**Данный скрипт позволяет просмотреть карточку клиента ( все его данные ) и удалить его из таблицы*/

require_once "connect_db.php";//подключение к скрипту
$table="SELECT * FROM Users";
$users=$pdo->query($table);
$kolvo_users=$users->fetchAll();
?>
<center>
<h1>Просмотр карточки клиента</h1>
<div style="padding-top: 10px">
    <!--Выбор клиента осуществлен с помощью выпадающего списка, каждое значение списка получено обращением к таблице
    -->

<form action="view_client.php" method="post">

    <select style="font-size: 20px; border-radius: 40px;cursor: pointer" required name="number">
        <option disabled selected>Выберите клиента</option>
        <?php
        foreach ($kolvo_users as $item)
        {
            // Вывод Ф.И.О. в виде выпадающего списка
            echo "<option value='$item[id]'>".$item['Surname']." ".$item['Imya']." ".$item['Otchestvo']."</option>";
        }
        ?>
    </select><br><br>
    <!--
    Кнопка по которой необходимо нажать после выбора из выпадающего списка нужного клиента
    -->
        <input class="mainbutton" type="submit" name="click" value="Просмотреть" style='font-size: 20px;border-radius: 4px;cursor: pointer'>

</form>
</div>
</center>
<!-- Данная ссылка ( в виде кнопки из-за класса в main.css ) видна на всех страницах приложения, кроме главной.
Благодаря ей пользователь может всегда вернуться в главное меню-->
<div style="position: fixed; left: 0;bottom: 0; padding-left: 20px;padding-bottom: 20px">
    <a href="index.html" class="mainbutton">На главную</a>
</div>
<?php
//Если была нажата кнопка Просмотреть и выбранный элемент не равен 0, т.к. 0 в данном случае это неактивный
// элемент из выпадающего списка:"Выберите клиента".
if(isset($_REQUEST['click'])&&@$_REQUEST['number']!=0)
{
    $deletetable=$pdo->exec("DROP TABLE IF EXISTS Lastuser");
    /** Создаем таблицу с выбранным клиентом*/
    $table2="CREATE TABLE IF NOT EXISTS Lastuser(
id INT NOT NULL,
Surname TINYTEXT NOT NULL,
Imya TINYTEXT NOT NULL,
Otchestvo TINYTEXT NOT NULL,
Birthday TINYTEXT NOT NULL,
Sex TINYTEXT NOT NULL,
Phone1 TINYTEXT NOT NULL,
Phone2 TINYTEXT,
PRIMARY KEY (id))";
    $create_table2=$pdo->exec($table2);//выполнение SQL запроса
    $add_to_table="INSERT INTO Lastuser VALUES (:id,:sur,:nam,:otch,:birth,:sex,:ph1,:ph2)";
    $string=$pdo->prepare($add_to_table);

    $id=$_REQUEST['number'];//получаем номер id клиента, которого выбрад пользователь и записываем в перемнную
    $query = "SELECT * FROM Users WHERE id = $id";//SQL запрос, при котором указан конкретный уникальный идентификатор
    $out=$pdo->query($query);
    $vivod=$out->fetchAll();
    foreach ($vivod as $value)
    {
        /** Запись в переменные сессии все значений из таблицы(Фамилия Имя Отчество и тд) по данному id**/
        $string->execute(['id'=>$id,'sur' => $value['Surname'], 'nam' => $value['Imya'], 'otch' => $value['Otchestvo'], 'birth' => $value['Birthday'], 'sex' => $value['Sex'], 'ph1' => $value['Phone1'],'ph2'=>$value['Phone2']]);

        echo "<div style='font-size: 25px;margin-left: 40%;'>";
        echo "<br>Фамилия: ".$value['Surname']."<br>Имя: ".$value['Imya']."<br>Отчество: ".$value['Otchestvo']."<br>Дата рождения: ".$value['Birthday']."<br>Пол: ".$value['Sex']."<br> Дата создания клиента: ".$value['Date_Create']."<br> Дата обновления клиента: ".$value['Date_Update']."<br>Телефон основной: ".$value['Phone1']."<br>Телефон доп.: ".$value['Phone2'];
        echo "</div>";
    }

    /** Вывод двух кнопок, Удалить клиента и Редактировать клиента*/

    echo "<br><br><center><form action='view_client.php' method='post'>
<input type='submit' value='Удалить клиента' name='Delet' style='font-size: 20px;border-radius: 4px;cursor: pointer'>
</form><br><br>
<form action='add_client.php' method='post'>
<input type='submit' value='Редактировать клиента' name='Update' style='font-size: 20px;border-radius: 4px;cursor: pointer'>
</form></center>";

}

//Если нажата кнопка Удалить клиента, то запускается функция, которая принимает два аргумента

if(isset($_REQUEST['Delet'])) {
    $y="SELECT id FROM Lastuser ORDER BY id DESC LIMIT 1";
    $x=$pdo->query($y);
    $z=$x->fetchColumn();
    Delete($pdo, $z);
}

function Delete($pdo,$cnt)
{
    $del = "DELETE FROM Users WHERE id=$cnt";//Удаление конкретной строки из таблицы через id
    $pdo->exec($del);//запускает SQL-запрос на выполнение
    header("Refresh: 2; url=index.html");//Перенаправление на главную страницу через 2 ескунды
    echo"<div class=addclient><center><br><h1>Клиент удален из базы!</h1><br><h2><i>Ожидайте, производится перенаправление</i></h2></center></div>";
}
?>

</body>
</html>