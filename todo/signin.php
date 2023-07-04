<?php 
 require_once 'db_connect.php'; //подключение к БД

 $login = $_POST['login']; //получение логина, введенного пользователем
 $email = $_POST['email'];
 $password = md5($_POST['password']); //получение пароля, введенного пользователем и хеширование его

    $check_user = mysqli_query($connection, "SELECT * FROM `users_todo` WHERE `login` = '".$login."' AND `pass` = '".$password."' AND `email` = '".$email."'"); //запрос на получение пользователя с указанным логином и паролем
    if (mysqli_num_rows($check_user) > 0) { //если пользователь найден

        $user = mysqli_fetch_assoc($check_user); //получение данных пользователя из БД

        session_start(); //начало сессии
        $_SESSION['user']['id'] = $user["id"];
        session_regenerate_id(); //обновление ID сессии
        setcookie("session", session_id()); //установка cookie с ID сессии
        mysqli_query($connection, "INSERT INTO `sessions_todo`(`user_id`, `session`) VALUES (".$user["id"].", '".session_id()."')"); //создание новой сессии для пользователя
        header('Location: index.php'); //перенаправление пользователя на главную страницу

    } else {
        header('Location: authorization.php'); //если пользователь не найден, перенаправление на страницу авторизации
    }
?>
