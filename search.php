<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <title>Поиск клиента</title>
</head>
<body>
<center>
    <br>
    <h1>Поиск клиента</h1>
    <!-- Форма выбора каким способом осуществлять поиск клиента по номеру телефону или по фамилии.
    каждому <input`у> присваивается поле name="имя_переменной", для того чтобы можно было получать эти данные
    на PHP и работать с ними в дальнейшем-->
<form action="search.php" method="post" style="padding-top: 150px">
    <input class="mainbutton" type="submit" name="surname" value="По фамилии" style="cursor: pointer">
    <input class="mainbutton" type="submit" name="phone" value="По телефону" style="cursor: pointer"><br>
</form>
</center>
<?php
/** Данный скрипт выполняет алгоритмы поиска по фамилии клиента или по номеру телефона*/

//Если была нажата кнопка поиск по фамилии
if(isset($_REQUEST['surname']))
{
    //То появляется новая форма где необходимо написать фамилию клиента и нажать кнопку "Найти"
    echo "<center><form action='search.php' method='post' style='padding-top: 50px'>
    <input type='text' name='sur' placeholder='Фамилия' style='font-size: 30px;border-radius: 10px' required><br><br>
    <input type='submit' value='Найти' style='font-size: 20px;border-radius: 4px;cursor: pointer'>
</form>
</center>";
}
//Если была нажата кнопка поиск по номеру телефона
else if(isset($_REQUEST['phone']))
{
    //То появляется новая форма где необходимо написать телефон клиента и нажать кнопку "Найти"
    echo "<center><div style='font-size: 30px'> <form action='search.php' method='post' style='padding-top: 50px'>
    +7 <input type='text' name='tel' placeholder='9183417629' style='font-size: 30px;border-radius: 10px' required><p></p>
    <input type='submit' value='Найти' style='font-size: 20px;border-radius: 4px;cursor: pointer'>
</form>
</div>
</center>";
}
require_once "connect_db.php";//выполняется подключение к скрипту "connect_db.php"
$table="SELECT * FROM Users";//Запрос SQL Для просмотра таблицы Users
$users=$pdo->query($table);//выполняет SQL-запрос без подготовки и возвращает набор элементов в виде объекта.
$kolvo_users=$users->fetchAll();//получение массива в виде строк из таблицы

$lucky=false;//булева переменная для запуска функции вывода таблицы
//P.S. Данные поиски ориентировны не только на поиск одного клиента, но т.к. по фамилии может быть несколько клиентов,
//то алгоритм найдет все совпадения, вне зависимости от их количества
if(isset($_REQUEST['sur']))//если поиск идет по фамилии
{
    $fam=$_REQUEST['sur'];
    foreach ($kolvo_users as $value)//методом перебора из массива параметр $value['имя_столбца'] может принимать значения из таблицы
    {
        $str=$value['Surname'];//присвоение переменной $str значение Фамилии
        if(mb_strtolower($value['Surname'])==mb_strtolower($fam)) //если вдруг пользователь ввел первую букву
            // маленькой или большой( из-за ошибки), то произойдет уменьшение всей строки к нижнему регистру и если
            //вводимый запрос совпадет со значением из таблицы то выводим клиента-(ов)
            {
            if($lucky==false) {
                Ura();//запуск функции по условию
            }
            //вывод в виде таблицы клиента -(ов)
            echo "<center>
    <table border='1' cellpadding='10' width='90%'>
        <tr>
            <th width='20px'>
            $value[id]
            </th>
            <th width='150px'>
            $value[Surname]
            </th>
            <th width='100px'>
            $value[Imya]
            </th>
            <th width='120px'>
            $value[Otchestvo]
            </th>
            <th width='100px'>
            $value[Birthday]
            </th>
            <th width='70px'>
            $value[Sex]
            </th>
            <th width='100px'>
            $value[Phone1]
            </th>
        </tr>
    </table><br>
</center>";
            $lucky=true;
        }
    }
}
else if(isset($_REQUEST['tel']))//если нажата кнопка найти по телефону
{
    //аналогично как и с нахождением фамилии
    $phone=$_REQUEST['tel'];
    foreach ($kolvo_users as $item)//методом перебора из массива параметр $value['имя_столбца'] может принимать значения из таблицы
    {
        if($item['Phone1']==$phone)
        {
            if($lucky==false) {
                Ura();
            }
            echo "<center>
    <table border='1' cellpadding='10' width='90%'>
        <tr>
            <th width='20px'>
            $item[id]
            </th>
            <th width='150px'>
            $item[Surname]
            </th>
            <th width='100px'>
            $item[Imya]
            </th>
            <th width='120px'>
            $item[Otchestvo]
            </th>
            <th width='100px'>
            $item[Birthday]
            </th>
            <th width='70px'>
            $item[Sex]
            </th>
            <th width='100px'>
            $item[Phone1]
            </th>
        </tr>
    </table><br>
</center>";
            $lucky=true;
        }
    }
}
//функция которая всего один раз запускается для корректного отображения первой строки
function Ura()
{
    echo "<center><h1>Клиент(ы) найден(ы)!</h1></center>";
    echo "<center><table border='1' cellpadding='10' width='90%'>
        <tr>
            <th width='20px'>
            ID
            </th>
            <th width='150px'>
            Фамилия
            </th>
            <th width='100px'>
            Имя
            </th>
            <th width='120px'>
            Отчество
            </th>
            <th width='100px'>
            День рождения
        </th>
            <th width='70px'>
            Пол
            </th>
            <th width='100px'>
            Телефон основной
        </th>
        </tr>
    </table><br>
</center>";
}
//Если пользователь нажал кнопку найти ( по фамилии или по телефону ) и совпадений не нашлось, то выйдет оповещение
//Что данного клиента не существует
if((isset($_REQUEST['sur']))||(isset($_REQUEST['tel']))) {
    if ($lucky == true) {

    } else {
        echo "<center><h1>Такого клиента нет!</h1></center>";
    }
}
?>
<!-- Данная ссылка ( в виде кнопки из-за класса в main.css ) видна на всех страницах приложения, кроме главной.
Благодаря ей пользователь может всегда вернуться в главное меню-->
<div style="position: fixed; left: 0;bottom: 0; padding-left: 20px;padding-bottom: 20px">
    <a href="index.html" class="mainbutton">На главную</a>
</div>
</body>
</html>