<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

    <!-- Форма регистрации -->

    <form action="signup.php" method="post" >
        <label>Эл. почта</label>
        <input type="text" name="email" placeholder="Введите свою электронную почту">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <button type="submit">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href='authorization.php'>Авторизируйтесь</a>!
        </p>
    </form>

</body>
</html>