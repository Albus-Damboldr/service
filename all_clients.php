<?php
/** Данный скрипт выводит всех клиентов на страницу в виде таблицы*/

require_once "connect_db.php";//выполняется подключение к скрипту "connect_db.php"
$table="SELECT * FROM Users";//Запрос SQL Для просмотра таблицы Users
$users=$pdo->query($table);//выполняет SQL-запрос без подготовки и возвращает набор элементов в виде объекта.
$kolvo_users=$users->fetchAll();//получение массива в виде строк из таблицы

//Вывод первой строки с общими полями

echo "<html>
<head>
<title>Все клиенты</title>
<link rel='stylesheet' href='main.css'>
</head>
<body><center><div class=addclient><h1>Все клиенты</h1></div><br>
    <table border='1' cellpadding='10' width='90%'>
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
            <th width='100px'>
                Телефон доп.
            </th>
        </tr>
    </table><br>
</center></body></html>";

//методом перебора из массива параметр $item['имя_столбца'] может принимать значения из таблицы
//вывод каждого значения осуществляется в виде ячейки таблицы

foreach ($kolvo_users as $item)
{
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
            <th width='100px'>
                $item[Phone2]
            </th>
        </tr>
    </table><br>
</center>";
}

/**Данная ссылка ( в виде кнопки из-за класса в main.css ) видна на всех страницах приложения, кроме главной.
Благодаря ей пользователь может всегда вернуться в главное меню **/

echo "<div style=\"position: fixed; left: 0;bottom: 0; padding-left: 20px;padding-bottom: 20px\">
    <a href=\"index.html\" class=\"mainbutton\">На главную</a>
</div>"
?>