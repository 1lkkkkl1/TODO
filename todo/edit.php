<?php
if(isset($_GET['id'])){
    require 'db_connect.php';

    // Получаем значение параметра id из GET запроса
$id = $_GET['id'];

// Если значение параметра пустое, выводим 0 и завершаем выполнение скрипта
if(empty($id)){
   echo 0;
}else {
    // Формируем запрос на обновление задачи с указанным id
    $query = "UPDATE `tasks` SET `task`='".$_POST["title"]."' WHERE `id`=".$id;
        
    // Выполняем запрос к базе данных
    $result = mysqli_query($connection, $query);
    
    // Если запрос не удался, выводим сообщение об ошибке и завершаем выполнение скрипта
    if(!$result) exit("ошибка в запросе<br>".$query);
    
    // Если запрос выполнен успешно, перенаправляем пользователя на главную страницу
    header('Location: index.php');

}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-section">
        <div class="add-section">
          <form action="edit.php?id=<?echo $_POST["id"]?>" method="POST" autocomplete="off">
              <input type="text" 
                     name="title" 
                     placeholder="Введите измененную задачу" required/>
              <button type="submit">Изменить &nbsp; <span>&#43;</span></button>
          </form>
       </div>
    </div>
</body>
</html>