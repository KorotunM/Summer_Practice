<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  $errors = array();
  
  $errors['department'] = !empty($_COOKIE['department_error']);
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['adres'] = !empty($_COOKIE['adres_error']);

  if($errors['department']){
    setcookie('department_error','',100000);
    setcookie('department_value','',100000);
    $messages['department'] = '<div class="error"> Введите департамент </div>';
  }
 if ($errors['fio']) {
  setcookie('fio_error', '', 100000);
  setcookie('fio_value','',100000);
  $messages['fio'] = '<div class="error">Заполните имя. Доступные символы: символы алфавита, пробел </div>';
 }

 if($errors['adres']){
    setcookie('adres_error','',100000);
    setcookie('adres_value','',100000);
    $messages['adres'] = '<div class="error"> Заполните адрес, доступные символы: прописные и строчные буквы, цифры, пробел, ",", ".", "-" </div>';
  }

  foreach($_COOKIE as $key => $value) {
    setcookie($key, '', 100000);
  }
  
  $values = array();
  $values['department'] = empty($_COOKIE['department_value']) ? '' : (strip_tags($_COOKIE['department_value']));
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
  $values['adres'] = empty($_COOKIE['adres_value']) ? '' : strip_tags($_COOKIE['adres_value']);
  include('../Forms/DepartmentForm.php');
}
else {
  include('../password.php');
 $errors = FALSE;

 $patternDep = '/^[\p{Cyrillic}A-Za-z0-9\s]+$/u';
 if (empty($_POST['department']) || !preg_match($patternDep, $_POST['department'])) {
    setcookie('department_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('department_value', $_POST['department'], time() + 12 * 30 * 24 * 60 * 60);

 if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
   setcookie('fio_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);

 $pattern = '/^[0-9\p{Cyrillic}A-Za-z,\s.\-]+$/u';
 if (empty($_POST['adres']) || !preg_match($pattern, $_POST['adres'])) {
    setcookie('adres_error','1',time() + 24 * 60 * 60);
    $errors = TRUE;
}
 setcookie('adres_value', $_POST['adres'], time() + 12 * 30 * 24 * 60 * 60);

  if ($errors) {
    header('Location: DepartmentIndex.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('department_error', '', 100000);
    setcookie('adres_error', '', 100000);
  }

  foreach($_COOKIE as $key => $value) {
    setcookie($key, '', 100000);
  }

  if (!empty($_COOKIE['id_value'])) {
    try {
        $stmt = $db->prepare("UPDATE department SET manager_name = ?, adres = ?, department_name = ? WHERE department_id = ?");
        $stmt->execute([$_POST['fio'], $_POST['adres'], $_POST['department'], $_COOKIE['id_value']]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
    setcookie('id_value','', 10000,'/');
} else {
    try {
        $stmt = $db->prepare("INSERT INTO department (department_name, manager_name, adres) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['department'], $_POST['fio'], $_POST['adres']]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
}
setcookie('save','1');
header('Location: ../Tables/DepartmentTable.php');
}
