<?php
// Подключение к базе данных и другие необходимые действия
include_once("db_connect.php"); // Подключение к базе данных
include_once("config.php");

if (isset($_POST['access'])) {
    $access = $_POST['access'];

    // Получение идентификатора пользователя на основе текущей сессии
    $session = $_COOKIE["session"];
    $query = "SELECT user_id FROM sessions_todo WHERE session = '$session'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Обновление значения поля access у соответствующего пользователя
        $update_query = "UPDATE users_todo SET access = '$access' WHERE id = '$user_id'";

        if (mysqli_query($connection, $update_query)) {
            // Запрос выполнен успешно
            echo "Значение поля access успешно обновлено для текущего пользователя";
        } else {
            // Возникла ошибка при выполнении запроса
            echo "Ошибка при обновлении значения поля access: " . mysqli_error($connection);
        }
    } else {
        // Пользователь не найден или возникла ошибка при выполнении запроса
        echo "Ошибка при получении идентификатора пользователя";
    }
}
?>
