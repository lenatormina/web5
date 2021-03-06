<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
 
  $messages = array();

  if (!empty($_COOKIE['save'])) {
   
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
   
    $messages[] = 'Спасибо, результаты сохранены.';
   
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['radio-group-1'] = !empty($_COOKIE['radio-group-1_error']);
  $errors['radio-group-2'] = !empty($_COOKIE['radio-group-2_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  
  $errors2 = array();
  $errors2['name'] = !empty($_COOKIE['name_error2']);
  $errors2['email'] = !empty($_COOKIE['email_error2']);

  if ($errors['name']) {
   
    setcookie('name_error', '', 100000);
    
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните email.</div>';
  }
  if ($errors['radio-group-1']) {
    setcookie('radio-group-1_error', '', 100000);
    $messages[] = '<div class="error">Заполните пол.</div>';
  }
  if ($errors['radio-group-2']) {
    setcookie('radio-group-2_error', '', 100000);
    $messages[] = '<div class="error">Заполните количество конечностей.</div>';
  }
  if ($errors['super']) {
    setcookie('super_error', '', 100000);
    $messages[] = '<div class="error">Заполните суперспособности.</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  
  if ($errors2['name']) {
    setcookie('name_error2', '', 100000);
    $messages[] = '<div class="error">Неверный формат имени. Допустимы только буквы.</div>';
  }
  if ($errors2['email']) {
    setcookie('email_error2', '', 100000);
    $messages[] = '<div class="error">Неверный формат email. Допустимы латинские буквы, цифры, знак подчеркивания. Пример: login@domen.ru</div>';
  }
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['year'] = empty($_COOKIE['year_value']) ? '' : strip_tags($_COOKIE['year_value']);
  $values['radio-group-1'] = empty($_COOKIE['radio-group-1_value']) ? '' : strip_tags($_COOKIE['radio-group-1_value']);
  $values['radio-group-2'] = empty($_COOKIE['radio-group-2_value']) ? '' : strip_tags($_COOKIE['radio-group-2_value']);
  $values['super'] = empty($_COOKIE['super_value']) ? '' : strip_tags($_COOKIE['super_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
  $values['check'] = empty($_COOKIE['check_value']) ? '' : strip_tags($_COOKIE['check_value']);
  
  if (session_start() && !empty($_SESSION['login'])) {
    
    $user = 'u41181';
    $password = '2342349';
    $db = new PDO('mysql:host=localhost;dbname=u41181', $user, $password, array(PDO::ATTR_PERSISTENT => true));

  try {
    $login = $_SESSION['login'];

    $stmt = $db->prepare("SELECT * FROM form2 WHERE login = '$login'");
    $stmt->execute();
    foreach ($stmt as $row) {
      $values['name']=$row["name"];
      $values['email'] = $row["email"];
      $values['year'] = $row["year"];
      $values['radio-group-1'] = $row["sex"];
      $values['radio-group-2'] = $row["number_of_limbs"];
      $values['super'] = $row["superpowers"];
      $values['bio'] = $row["biography"];
      $values['check'] = $row["checkbox"];
      }

    }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
   }
    
    
    printf('Вход с логином %s', $_SESSION['login']);
    $messages[] = sprintf('Вы можете <a href="login.php">выйти</a>');
  }
  else {
    $messages[] = sprintf('Вы можете <a href="login.php">войти</a> если уже зарегистрированы');
  }


  include('form.php');
}

else {
 
  $errors = FALSE;
  $errors2 = FALSE;
  if (empty($_POST['name'])) {
    
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);

  if (empty($_POST['radio-group-1'])) {
    setcookie('radio-group-1_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('radio-group-1_value', $_POST['radio-group-1'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['radio-group-2'])) {
    setcookie('radio-group-2_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('radio-group-2_value', $_POST['radio-group-2'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['super'])) {
    setcookie('super_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('super_value', $_POST['super'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }
  
  
  if (!preg_match("/^[a-zа-яё]+$/i", $_POST['name']) && ("" != $_POST['name'])) {
    setcookie('name_error2', '1', time() + 24 * 60 * 60);
    $errors2 = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  } 
  
  if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['email']) && ("" != $_POST['email'])) {
    setcookie('email_error2', '1', time() + 24 * 60 * 60);
    $errors2 = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  } 

  setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);

  if ($errors || $errors2) {
   
    header('Location: index.php');
    exit();
  }
  else {
    
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('radio-group-1_error', '', 100000);
    setcookie('radio-group-2_error', '', 100000);
    setcookie('super_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('name_error2', '', 100000);
    setcookie('email_error2', '', 100000);
   
  }

  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    
    $user = 'u41181';
    $password = '2342349';
    $db = new PDO('mysql:host=localhost;dbname=u41181', $user, $password, array(PDO::ATTR_PERSISTENT => true));

  try {
    $login = $_SESSION['login'];
    $stmt = $db->prepare("UPDATE form2 SET name=:name, email=:email, year=:year, sex=:sex, number_of_limbs=:number_of_limbs, superpowers=:superpowers, biography=:biography, checkbox=:checkbox WHERE login = '$login'");

    $stmt -> bindParam(':name', $name);
    $stmt -> bindParam(':email', $email);
    $stmt -> bindParam(':year', $year);
    $stmt -> bindParam(':sex', $sex);
    $stmt -> bindParam(':number_of_limbs', $number_of_limbs);
    $stmt -> bindParam(':superpowers', $superpowers);
    $stmt -> bindParam(':biography', $biography);
    $stmt -> bindParam(':checkbox', $checkbox);
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $sex = $_POST['radio-group-1'];
    $number_of_limbs = $_POST['radio-group-2'];
    $superpowers = $_POST['super'];
    $biography = $_POST['bio'];
    if (empty($_POST['check']))
      $checkbox = "No";
    else
      $checkbox = $_POST['check'];

    $stmt->execute();
  }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
  }
  else {
    $user = 'u41181';
    $password = '2342349';
    $db = new PDO('mysql:host=localhost;dbname=u41181', $user, $password, array(PDO::ATTR_PERSISTENT => true));

  try {
    $stmt = $db->prepare("INSERT INTO form2 (name, email, year, sex, number_of_limbs, superpowers, biography, checkbox, login, passwordmd) 
    VALUES (:name, :email, :year, :sex, :number_of_limbs, :superpowers, :biography, :checkbox, :login, :passwordmd)");

    $stmt -> bindParam(':name', $name);
    $stmt -> bindParam(':email', $email);
    $stmt -> bindParam(':year', $year);
    $stmt -> bindParam(':sex', $sex);
    $stmt -> bindParam(':number_of_limbs', $number_of_limbs);
    $stmt -> bindParam(':superpowers', $superpowers);
    $stmt -> bindParam(':biography', $biography);
    $stmt -> bindParam(':checkbox', $checkbox);
    $stmt -> bindParam(':login', $login);
    $stmt -> bindParam(':passwordmd', $passwordmd);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $sex = $_POST['radio-group-1'];
    $number_of_limbs = $_POST['radio-group-2'];
    $superpowers = $_POST['super'];
    $biography = $_POST['bio'];
    if (empty($_POST['check']))
      $checkbox = "No";
    else
      $checkbox = $_POST['check'];
    
    $permitted_chars1 = 'abcdefghijklmnopqrstuvwxyz';
    $permitted_chars2 = '0123456789';
    $login = substr(str_shuffle($permitted_chars1), 0, 10);
    $pass = substr(str_shuffle($permitted_chars2), 0, 6); 
    $passwordmd = md5($pass);
   
    setcookie('login', $login);
    setcookie('pass', $pass);

    $stmt->execute();
  }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
  }

 
  setcookie('save', '1');

 
  header('Location: ./');
}
