<?php

//Если был отправлен POST-запрос с параметром complete_id, то задача с указанным id помечается как завершенная, устанавливая поле completed в true. 
//Затем происходит перенаправление на главную страницу.
if(isset($_POST['complete_id'])){
    $id=$_POST['complete_id'];
    require 'db_connect.php';
    $query = "UPDATE `tasks` SET `completed`=true WHERE `id`=".$id;
            
    $result = mysqli_query($connection, $query);
    if(!$result) exit("ошибка в запросе<br>".$query);
        
    header('Location: index.php');
}
//Если был отправлен POST-запрос с параметром repair_id, то задача с указанным id помечается как незавершенная, устанавливая поле completed в false. 
//Затем происходит перенаправление на главную страницу.
else if(isset($_POST['repair_id'])){
    $id=$_POST['repair_id'];
    require 'db_connect.php';
    $query = "UPDATE `tasks` SET `completed`=false WHERE `id`=".$id;
            
    $result = mysqli_query($connection, $query);
    if(!$result) exit("ошибка в запросе<br>".$query);
        
    header('Location: index.php');
}
else {
    header("Location: index.php?mess=error");
}