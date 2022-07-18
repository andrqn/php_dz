<?php
#переменные тут для удобства написания,как я понял их потом можно будет указать по другому и ввести в оборот $email=$_POST["email"] и тд?
$email="sdadadad@gmail.com";
$age=44;
$name="wae--5";
$captcha=4;
$date=date("d.m.y");
$gender="female";
if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "введи правильный email";
#ну и эхо с ошибками так же для проверки работы формы валидации 
}else {
    echo "Твой email $email введен верно \n";
}
if ($age > 10 && $age < 99 ){
    echo "Возраст указан верно\n";
}else {
    echo "Вы слишком молоды\n";
}
if (!ctype_alpha($name)){
    echo "Имя может содержать только символы a-z,A-Z\n";
}
if ($captcha !=4){
    echo "Попробуйте еще раз\n";
}
if ($gender=="female" and $date=="08.03.21"){
    echo "Поздравляем с первым праздником весны!!\n";
}
