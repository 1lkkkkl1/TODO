<?php

if(isset($_GET['id'])){ // Проверяем, был ли передан параметр 'id' через GET-запрос
    require 'db_connect.php'; // Подключаемся к базе данных

    $id = $_GET['id']; // Получаем значение параметра 'id'

    if(empty($id)){ // Если параметр 'id' пуст, то выводим 0
       echo 0;
    }else {
        $query = "UPDATE `tasks` SET `deleted`=true WHERE `id`=".$id; // Формируем SQL-запрос на удаление задачи с указанным 'id', устанавливая значение поля 'deleted' в true
            
        $result = mysqli_query($connection, $query); // Выполняем запрос
        if(!$result) exit("ошибка в запросе<br>".$query); // Если запрос не удался, то выводим ошибку
        
        header('Location: index.php'); // Перенаправляем пользователя на главную страницу
    }
}else {
    header("Location: index.php"); // Если параметр 'id' не был передан, то перенаправляем пользователя на главную страницу
}