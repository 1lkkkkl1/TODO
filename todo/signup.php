<?php
    require_once 'db_connect.php';

    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $password_confirm = $_POST['password_confirm'];

    if ($password == $password_confirm && $password != "") { //проверка на совпадение паролей

        $password = md5($password); //хеширование паролей

        $res = mysqli_query($connection, "INSERT INTO `users_todo` (`login`, `pass`, `email`) VALUES ('".$login."','".$password."','".$email."')"); //добавление нового пользователя в базу данных

        if(!$res) exit("ошибка в запросе<br>");

        $check_user = mysqli_query($connection, "SELECT * FROM `users_todo` WHERE `login` = '".$login."' AND `pass` = '".$password."' AND `email` = '".$email."'");
        if (mysqli_num_rows($check_user) > 0) { //если найден пользователь с таким логином и паролем

        $user = mysqli_fetch_assoc($check_user);
        session_start();
        session_regenerate_id();
        setcookie("session", session_id()); //установка куки с ID сессии
        mysqli_query($connection, "INSERT INTO `sessions_todo`(`user_id`, `session`) VALUES (".$user["id"].", '".session_id()."')"); //связывание пользователя с текущей сессией
        }
        header('Location: index.php'); //переход на главную страницу
    } else {
        header('Location: register.php'); //если пароли не совпадают, переход на страницу регистрации
    }

?>
