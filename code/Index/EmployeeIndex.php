<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['tel'] = !empty($_COOKIE['tel_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['position'] = !empty($_COOKIE['position_error']);
  $errors['department'] = !empty($_COOKIE['department_error']);

 if ($errors['fio']) {
  setcookie('fio_error', '', 100000);
  setcookie('fio_value','',100000);
  $messages['fio'] = '<div class="error">Заполните имя. Доступные символы: символы алфавита, пробел </div>';
}
if($errors['tel']){
  setcookie('tel_error','',100000);
  setcookie('tel_value','',100000);
  $messages['tel'] = '<div class="error"> Заполните телефон. Доступные символы: "+" и далее арабские цифры</div>';
}
if($errors['email']){
  setcookie('email_error','',100000);
  setcookie('email_value','',100000);
  $messages['email'] = '<div class="error"> Заполните почту. Доступные символы: символы алфавита, арабские цифры, "@" </div>';
}
if($errors['position']){
    setcookie('position_error','',100000);
    setcookie('position_value','',100000);
    $messages['position'] = '<div class="error"> Заполните должность, доступные символы: прописные и строчные буквы </div>';
  }
if($errors['department']){
  setcookie('department_error','',100000);
  setcookie('department_value','',100000);
  $messages['department'] = '<div class="error"> Выберите департамент </div>';
}

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
  $values['tel'] = empty($_COOKIE['tel_value']) ? '' : strip_tags($_COOKIE['tel_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['position'] = empty($_COOKIE['position_value']) ? '' : strip_tags($_COOKIE['position_value']);
  $values['department'] = empty($_COOKIE['department_value']) ? '' : ($_COOKIE['department_value']);
  include('../Forms/EmployeeForm.php');
}
else {
  include('../password.php');
 $errors = FALSE;
 if (empty($_POST['fio']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['fio'])) {
   setcookie('fio_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);
 
 if (empty($_POST['tel']) || !preg_match('/^\+[0-9]{11}$/', $_POST['tel'])) {
   setcookie('tel_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('tel_value', $_POST['tel'], time() + 12 * 30 * 24 * 60 * 60);
 
 if (empty ($_POST['email']) || !preg_match('/^([a-z0-9_-]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i', $_POST['email'])) {
   setcookie('email_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);

 if (empty ($_POST['position']) || !preg_match('/^[a-zA-Zа-яА-Я]+$/', $_POST['position'])) {
    setcookie('position_error','1',time() + 24 * 60 * 60);
    $errors = TRUE;
 }
 setcookie('position_value', $_POST['position'], time() + 12 * 30 * 24 * 60 * 60);

 if (empty($_POST['department'])) {
   setcookie('department_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('department_value', $_POST['department'], time() + 12 * 30 * 24 * 60 * 60);

  if ($errors) {
    header('Location: EmployeeIndex.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('tel_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('position_error', '', 100000);
    setcookie('department_error', '', 100000);
  }
  foreach($_COOKIE as $key => $value) {
    setcookie($key, '', 100000);
 }
  if (!empty($_COOKIE['id_value'])) {
    $department_id = $_POST['department'];
    try {
        $stmt = $db->prepare("UPDATE employee SET fio = ?, tel = ?, email = ?, position = ?, department_id = ? WHERE employee_id = ?");
        $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['position'], $department_id, $_COOKIE['id_value']]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
    setcookie('id_value','', 10000,'/');
} else {
    $department_id = $_POST['department'];
    try {
        $stmt = $db->prepare("INSERT INTO employee (fio, tel, email, position, department_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['position'], $department_id]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
}
setcookie('save','1');
header('Location: ../Tables/EmployeeTable.php');

}
