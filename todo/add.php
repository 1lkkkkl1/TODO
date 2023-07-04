<?php

if(isset($_POST['title'])){
    require 'db_connect.php';

    $title = $_POST['title'];

    // Проверка на пустоту поля "Задача"
    if(empty($title)){
        header("Location: index.php?mess=error");
    }else {

        // Формирование запроса на добавление новой задачи в БД
        $query = "INSERT INTO tasks(`userid`, `task`) VALUES ((SELECT `user_id` FROM `sessions_todo` WHERE `session`='".$_COOKIE["session"]."'), '".$_POST['title']."')";
            
        // Выполнение запроса
        $result = mysqli_query($connection, $query);

        // Проверка на ошибку выполнения запроса
        if(!$result) exit("ошибка в запросе<br>".$query);
        
        // Перенаправление на главную страницу после успешного выполнения запроса
        header('Location: index.php');
    }
}else {
    // Перенаправление на главную страницу с сообщением об ошибке при отсутствии значения поля "Задача"
    header("Location: index.php?mess=error");
}