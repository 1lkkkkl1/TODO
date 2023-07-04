<?php
//удаление сессии из cookies
setcookie("session", null, time()-3600);
setcookie("PHPSESSID", null, time()-3600);
header('Location: authorization.php');