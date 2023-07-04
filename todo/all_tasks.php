<?php
include_once("db_connect.php");
include_once("config.php");

// Проверка авторизации пользователя
if (!isset($_COOKIE["session"])) {
    header('Location: authorization.php');
    exit();
}

// Получение ID текущего пользователя
$session = $_COOKIE["session"];
$userQuery = "SELECT user_id FROM sessions_todo WHERE session='$session'";
$userResult = mysqli_query($connection, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$currentUserId = $userData['user_id'];

// Запрос для получения всех задач всех пользователей, за исключением текущего пользователя

$query = "SELECT tasks.task, tasks.date, tasks.completed
          FROM tasks
          INNER JOIN users_todo ON tasks.userid = users_todo.id
          WHERE users_todo.access = 1 AND tasks.deleted = false
          AND tasks.userid != '$currentUserId'";


$result = mysqli_query($connection, $query);

// Проверка успешности выполнения запроса
if (!$result) {
    exit("<p>Ошибка в запросе: " . mysqli_error($connection) . "</p>");
}

// Извлечение всех строк результата запроса в ассоциативный массив
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Все задачи</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .button {
  background-color: #F5F5F5; 
  border-radius: 8px; 
  border: 2px solid #363636; 
  font-size: 25px;
  -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
  margin-left: ;
 }
.textstyle{
  font-size: 40px; 
  text-decoration: none;

  text-align: center;
}

    </style>
</head>
<body>
    <div class="main-section empty">
        <h1 class="textstyle" style="margin-bottom: 30px;">Все задачи</h1>
        

        <div class="task-list" style="margin-bottom: 10px;">
            <?php foreach ($tasks as $task) { ?>
    <div class="task">
        <h2><?php echo $task['task']; ?></h2>
        <p>Дата создания: <?php echo $task['date']; ?></p>
        <p>Статус: <?php echo $task['completed'] ? 'Выполнено' : 'В процессе'; ?></p>
        <hr>
    </div>
          <?php } ?>

        </div>
      <a style="text-decoration: none; color: black; padding: 1px;" href="index.php" class="button"><i class="textstyle"></i>Вернуться к задачам</a>
    </div>
</body>
</html>

