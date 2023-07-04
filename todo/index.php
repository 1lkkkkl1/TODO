<?php
if(!isset($_COOKIE["session"])){
    header('Location: authorization.php'); // Если куки-сессия не установлена, перенаправляем пользователя на страницу авторизации
    exit();
}
set_time_limit(120); // Устанавливаем максимальное время выполнения скрипта в 120 секунд
include_once("db_connect.php"); // Подключаем скрипт для подключения к базе данных
include_once("config.php"); // Подключаем файл с конфигурацией

$order=""; // Инициализируем переменную для сортировки
$from=""; // Инициализируем переменную для фильтрации по дате начала
$to=""; // Инициализируем переменную для фильтрации по дате окончания
if(isset($_POST["order"])) $order=$_POST["order"]; // Если передан параметр order, присваиваем его значение переменной order
if(isset($_POST["from"]) && $_POST["from"] != "") $from=" AND `date` >= '".$_POST["from"]."'"; // Если передан параметр from и он не пустой, создаем условие для фильтрации по дате начала
if(isset($_POST["to"]) && $_POST["to"] != "") $to=" AND `date` <= '".$_POST["to"]."'"; // Если передан параметр to и он не пустой, создаем условие для фильтрации по дате окончания
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Мои задачи</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
  <style>
    .button {
  background-color: #F5F5F5; 
  border-radius: 8px; 
  border: 2px solid #363636; 
  font-size: 15px;
  -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
  margin-left: 10px;
 }
.textstyle{
  font-size: 15px; 
  text-decoration: none;

  text-align: center;
}

    </style>
</head>
<body>

    <div class="main-section">
      <div class="btn-holder">
    <form action="logout.php" method="POST">
        <button type="submit">Выход</button>
    </form>

         
        <a style="text-decoration: none;" href="all_tasks.php" class="button textstyle"><i class="fa"></i>Задачи пользователей</a>
        <button id="open-access" title="Открыть доступ" class="button" onclick="changeAccess(1)"><i></i>Открыть доступ</button>
<button id="close-access" title="Закрыть доступ" class="button" onclick="changeAccess(0)"><i></i>Закрыть доступ</button>
        


  </div>
       <div class="add-section">
          <form action="add.php" method="POST" autocomplete="off">
              <input type="text" 
                     name="title" 
                     placeholder="What do you need to do?" required/>
              <button type="submit">Добавить &nbsp; <span>&#43;</span></button>
          </form>
       </div>
       
        <div class="sort">
        <form action="index.php" method="post" id="filters">
            <select name="order">
                <option value="" style="display: none;">Сортировка</option>
                <option value="ORDER BY `date` DESC">Сначала новые</option>
                <option value="ORDER BY `date` ASC">Сначала старые</option>
            </select>
            <div class="date">
                <label for="from">От:</label>
                <input type="date" name="from">
            </div>
            <div class="date">
                <label for="to">До:</label>
                <input type="date" name="to">
            </div>
            <br>
            <button type="submit">Показать</button>
            <button type="reset">Сбросить</button>
        </form>
        </div>

       <div class="show-todo-section">
            
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/f.png" width="100%" />
                        <img src="img/Ellipsis.gif" width="80px">
                        <?php  
                        // Определяем запрос для выборки задач из таблицы tasks,
                        // где поле "deleted" равно false, и фильтруем результаты по значениям $from и $to.
                        // Далее, выбираем только те задачи, которые относятся к пользователю с указанным "session" cookie.
                        // Наконец, применяем сортировку, заданную в переменной $order.
                        $query = "SELECT * FROM tasks WHERE `deleted`=false ".$from.$to." AND `userid`=(SELECT `user_id` FROM `sessions_todo` WHERE `session`='".$_COOKIE["session"]."') ".$order;
                        $result = mysqli_query($connection, $query);
                        // Если запрос не выполнен успешно, выводим сообщение об ошибке.
                        if(!$result) exit("<p>ошибка в запросе<br>".$query."</p>");
                        // Извлекаем все строки результата запроса в массив ассоциативных массивов и сохраняем в $data.
                        $data = mysqli_fetch_all($result,  MYSQLI_ASSOC);
                        ?>
                    </div>
                    
                    
                </div>
            
                <?php foreach($data as $value) { ?>
                <div class="todo-item">
                    <span id="<?php echo $value['id']; ?>"
                          class="remove-to-do"><a href="remove.php?id=<?echo $value['id'];?>">x</a></span>
                          <form action="edit.php" method="POST">
                            <button type="submit" name="id" value="<?echo $value['id'];?>">Редактировать</button>
                        </form>
                    <?php if($value['completed']){ ?> 
                        <form action="complete.php" method="POST">
                            <button type="submit" name="repair_id" value="<?echo $value['id'];?>">Восстановить</button>
                        </form>
                        <h2 class="checked"><?php echo $value['task'] ?></h2>
                    <?php }else { ?>
                        <form action="complete.php" method="POST">
                            <button type="submit" name="complete_id" value="<?echo $value['id'];?>">Выполнить</button>
                        </form>
                        <h2><?php echo $value['task'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $value['date'] ?></small> 
                </div>
            <?php } ?>
       </div>
    </div>
<script>
function changeAccess(accessValue) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      if (xhr.responseText === "success") {
        // Уведомление об успешном выполнении запроса
        alert("Ошибка при обновлении значения поля access");
      } else {
        // Возникла ошибка при выполнении запроса
        alert("Запрос выполнен");
      }
      
      console.log("Запрос успешно отправлен!");
    }
  };
  xhr.open("POST", "change_access.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("access=" + accessValue);
}


</script>

    
</body>
</html>