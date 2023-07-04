<?php
require "db_connect.php";
$data = $_POST;

if(isset($data['forgot'])){
    $query = "SELECT * FROM users_todo WHERE email = '".$data['email']."'";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
        if(isset($data['forgot'])){
            $query = "SELECT * FROM users_todo WHERE email = '".$data['email']."'";
             $result = mysqli_query($connection, $query);
            $user = mysqli_fetch_assoc($result);
        if($user){
        $key = md5($user['login'].rand(1000, 9999));
        $query = "UPDATE users_todo SET change_key = '".$key."' WHERE id = '".$user['id']."'";
        mysqli_query($connection, $query);

        $url = $site_url.'newpass.php?key='.$key;
        $message = $user['login'].", был выполнен запрос на изменение вашего пароля. \n\n Для изменения перейдите по ссылке: ".$url;

        mail($data['email'], 'Подтвердите действие!', $message);
        header('Location: authorization.php');
        }
        else{
        echo "Данный email не зарегистирован";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div align="center">
        <form action="forgot.php" method="post">
            <h1>Забыли пароль?</h1>
            <input type="email" name="email" placeholder="Email"><br>
            <button type="submit" name="forgot">Отправить письмо</button>
        </form>
</div>

</body>
</html>        
