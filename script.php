<?php
# продолжаем сессию
session_start();
$gender=$_SESSION["gender"];
$date=date("d.m.y");
$name = $_SESSION["name"];
$age=$_SESSION['age'];
if ($gender=="female" && $date=="02.02.21"){
    echo "<h1>Привет, $name . Поздравляем с прекрасным праздником 8 марта! </h1>";
}elseif ($gender=="male" && $date=='02.02.21'){
    echo "<h1>Привет, $name . Пора покупать подарки к 8 марта! </h1>";
}else{
    echo "<h1>Привет, $name </h1>";
}
if ($age >= 18 ){
    echo "<div>Content 18+ <div/>";    
}
# завершаем сессию и удаляем её данные
session_destroy();
?>
<html>
<head>
<title>HELLO</title>
</head>
<body>
<img src="/smile.jpg">
</body>
</html>