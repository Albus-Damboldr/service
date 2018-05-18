<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Подключение единственного скрипта css для более удобной визуализации.
    Данный скрипт подключается на каждой странице-->
    <link rel="stylesheet" href="main.css">
    <title>Добавление клиента</title>
</head>
<body>
<!--Данная страница использует форму для добавления нового клиента. Форма, по нажатию submit выполнит
последующие действия в скрипте add_new_client.php
Структура полей и тип:
Фамилия - текстовый (обязательное поле для заполнения)
Имя - текстовый  (обязательное поле для заполнения)
Отчество - текстовый   (обязательное поле для заполнения)
Дата рождения - дата ( день месяц год )   (обязательное поле для заполнения)
Пол - возможность выбора   (обязательное поле для заполнения)
Телефон основной - текст  (обязательное поле для заполнения)
Телефон дополнительный - текст  (необязательное поле для заполнения)
   -->
<div class="addclient">
    <center>
        <h1>Добавление клиента</h1>
<form method="post" action="add_new_client.php">
    Фамилия:  <input type="text" placeholder="Иванов" value="" name="fam" style="font-size: 20px;border-radius: 10px" title='Фамилия на кириллице, пробелы запрещены' pattern="^[А-Яа-яЁё]+$" required><br><br>
    Имя:      <input type="text" placeholder="Иван" value="" name="nam" style="font-size: 20px;border-radius: 10px" title='Имя на кириллице, пробелы запрещены' pattern="^[А-Яа-яЁё]+$" required><br><br>
    Отчество: <input type="text" placeholder="Иванович" value="" name="otch" style="font-size: 20px;border-radius: 10px" title='Отчество на кириллице, пробелы запрещены' pattern="^[А-Яа-яЁё]+$" required><br><br>
    Дата рождения: <input type="date" name="birthday" required style="font-size: 20px;border-radius: 10px"><br><br>
    Ваш пол: <select name="sex" style="font-size: 20px; border-radius: 40px;cursor: pointer" required>
        <option value="Мужской"> Мужской</option>
        <option value="Женский"> Женский</option>
    </select><br><br>
    Сотовый: +7 <input type="text" name="phone1" style="font-size: 20px;border-radius: 10px" pattern="[0-9]{10}" title="Номер телефона без 8-ки 9001002005" required><br><br>
    Рабочий (при наличии): +7 <input type="text" name="phone2" pattern="[0-9]{10}" title="Номер телефона без 8-ки 9001002005" style="font-size: 20px;border-radius: 10px"><br><br>
    <input type="submit" value="Добавить клиента" title="Добавить в базу" style="font-size: 20px;border-radius: 4px;cursor: pointer">
</form>
    </center>
</div>
<!-- Данная ссылка ( в виде кнопки из-за класса в main.css ) видна на всех страницах приложения, кроме главной.
Благодаря ей пользователь может всегда вернуться в главное меню-->
<div style="position: fixed; left: 0;bottom: 0; padding-left: 20px;padding-bottom: 20px">
    <a href="index.html" class="mainbutton">На главную</a>
</div>
</body>
</html>