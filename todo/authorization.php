<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<!-- Форма авторизации -->

    <form action="signin.php" method="post">
         <label>Эл. почта</label>
        <input type="text" name="email" placeholder="Введите свою электронную почту">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <button type="submit">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="register.php">Зарегистрируйтесь</a>!
        </p>

         <p>
           <a href="forgot.php">Забыли пароль?</a>
        </p>
    </form>

</body>
</html>