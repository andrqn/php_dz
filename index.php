
<!doctype html>

<html lang="en">
<head>
  <title>Form</title>
</head>

<body>
  
<form action="index.php" method="post" enctype="multipart/form-data" >
      <div>
        <p>Ваше имя:<input type="text" name="name" value="<?php if (isset($_POST['name'])) Echo $_POST['name']; ?>"/></p>    
        <p>Ваш возраст: <input type="number" name="age" value="<?php if (isset($_POST['age'])) Echo $_POST['age']; ?>"/></p>
        <p>Ваш email: <input type="text" name="email" value="<?php if (isset($_POST['email'])) Echo $_POST['email']; ?>"/></p>
        <p>Обо мне : <textarea  name="about_me" cols="40" rows="3" maxlength="300" placeholder="До 300 символов"></textarea></p>
        <p>Мужчина<input name="gender" type="radio" value="male"> </p>
        <p>Женщина<input name="gender" type="radio" value="female"> </p>
        <p>Сколько будет 2+2?: <input type="text" name="captcha1" placeholder="Только цифра(ы)" /></p>   
        <p>А напишите "ABC" наоборот ? : <input type="text" name="captcha2" placeholder="Только латинские буквы" /></p>
        
               
        <input type="file" name="image" placeholder="choose file"><br/>      
        <input type="submit" />
    </div>
  </form>
</body>
</html>

<?php

function sanitizeForm(): void
{
  if (isset($_POST['about_me']) && !empty($_POST['about_me'])) {
    $_POST['about_me'] = htmlspecialchars($_POST['about_me']);
  }

  $_POST["email"] = filter_var($_POST["email"]);
  $_POST['name'] = trim($_POST["name"]);
  
}

function isformValid(array $formData):array
{
  $errmsg=[];
  if ( !filter_var ( $_POST['email'] , FILTER_VALIDATE_EMAIL )){
    $errmsg[]="Введите правильный email";
  }
  if (!is_numeric($_POST['age']) || intval($_POST['age']) < 0 || intval($_POST['age'] > 99)) {   
    $errmsg[]="Возраст не соотвествует";
  }   
  if (!ctype_alpha( str_replace (" ", "",$_POST['name']))){
    $errmsg[]="Имя должно содержать только символы a-z,A-Z";
  }
  if ( $_POST['captcha1'] != 4 ){
    $errmsg[]="Вы ввели не верные данные проверки";  
  }
  if ($_POST['captcha2'] != "CBA"){
    $errmsg[]="Проверьте правильность введенных данных(abc)";
  }
  if(isset($_POST['name'])  === false || empty($_POST['name'])){
   $errmsg[]="Имя не может быть пустым";

  }
  ## тут должна была быть проверка поля " Обо мне " но зачем проверять проверку,если можно поставить ограничение в 300  символов ;)

  
  return ["valid" => empty($errmsg), "err" => $errmsg];
   
} 
function valIMG(array $formData):array
{
  $errimg=[];
  $nameimg=($_FILES['image']['name']);
  if (getimagesize($_FILES['image']['tmp_name']) === false){
    $errimg[]="Это не картинка!";
  }elseif (exif_imagetype($_FILES['image']) != IMAGETYPE_PNG && exif_imagetype($_FILES['image']) != IMAGETYPE_JPEG && (!stripos($_FILES['image']['name'],".jpg")==1)){
    $errimg[]="Выбран не верный формат изображения";
  }elseif ($_FILES['image']['size'] > 14000){
    $errimg[]="Размер превышает 14кб";
  }else{
    $nameimg=$_FILES['image']['name'];
    $tmpname=$_FILES['image']['tmp_name'];
    move_uploaded_file($tmpname,"C:/openserver/userdata/temp/upload",$nameimg);
  }
  return['valimg'=> empty($errimg),"errimg"=>$errimg];

}


function handleForm(): void
{
  # Если данные не были отправлены методом POST - игнор
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
  }

  sanitizeForm();

  $validationResult = isformValid($_POST);
  $valimgresult = valIMG($_FILES);

  print_r($validationResult);
  print_r($valimgresult);

  # Валидация
  if ($validationResult['valid'] && $valimgresult["valimg"]) {
    # начинаем новую сессию
    session_start();
    
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["age"] = $_POST["age"];
    $_SESSION["gender"] = $_POST["gender"];   
  
    # Переход на новую страницу
    header("Location: script.php");
  } else { 
    foreach ($validationResult['err'] as $errmsg) {
      # Вывод сообщения об ошибке
      echo "<h1 style='color:red;'>$errmsg</h1>\n";
    }
    foreach($valimgresult['errimg'] as $errimg){
      echo "<h1 style='color:red;'>$errimg</h1>\n";
    }
  }
}

handleForm();