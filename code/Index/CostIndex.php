<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  $errors = array();
  
  $errors['item'] = !empty($_COOKIE['item_error']);
  $errors['type'] = !empty($_COOKIE['type_error']);
  $errors['price'] = !empty($_COOKIE['price_error']);

  if($errors['item']){
    setcookie('item_error','',100000);
    setcookie('item_value','',100000);
    $messages['item'] = '<div class="error"> Введите название канцтовара, доступные символы: прописные и строчные буквы, цифры </div>';
  }
 if ($errors['type']) {
  setcookie('type_error', '', 100000);
  setcookie('type_value','',100000);
  $messages['type'] = '<div class="error">Выберите единицу измерения </div>';
 }

 if($errors['price']){
    setcookie('price_error','',100000);
    setcookie('price_value','',100000);
    $messages['price'] = '<div class="error"> Введите цену коректно, разрешённая запись "число.десятичная часть" </div>';
  }

  foreach($_COOKIE as $key => $value) {
    setcookie($key, '', 100000);
  }
  
  $values = array();
  $values['item'] = empty($_COOKIE['item_value']) ? '' : (strip_tags($_COOKIE['item_value']));
  $values['type'] = empty($_COOKIE['type_value']) ? '' : strip_tags($_COOKIE['type_value']);
  $values['price'] = empty($_COOKIE['price_value']) ? '' : strip_tags($_COOKIE['price_value']);
  include('../Forms/CostForm.php');
}
else {
  include('../password.php');
 $errors = FALSE;

 $patternDep = '/^[\p{Cyrillic}A-Za-z0-9\s]+$/u';
 if (empty($_POST['item']) || !preg_match($patternDep, $_POST['item'])) {
    setcookie('item_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  setcookie('item_value', $_POST['item'], time() + 12 * 30 * 24 * 60 * 60);

 if (empty($_POST['type']) || !preg_match('/^[а-яА-ЯёЁa-zA-Z\s-]{1,150}$/u', $_POST['type'])) {
   setcookie('type_error', '1', time() + 24 * 60 * 60);
   $errors = TRUE;
 }
 setcookie('type_value', $_POST['type'], time() + 12 * 30 * 24 * 60 * 60);

 $pattern = '/^[0-9\p{Cyrillic}A-Za-z,\s.\-]+$/u';
 if (empty($_POST['price']) || !preg_match($pattern, $_POST['price'])) {
    setcookie('price_error','1',time() + 24 * 60 * 60);
    $errors = TRUE;
}
 setcookie('price_value', $_POST['price'], time() + 12 * 30 * 24 * 60 * 60);

  if ($errors) {
    header('Location: CostIndex.php');
    exit();
  }
  else {
    setcookie('type_error', '', 100000);
    setcookie('item_error', '', 100000);
    setcookie('price_error', '', 100000);
  }

  foreach($_COOKIE as $key => $value) {
    setcookie($key, '', 100000);
  }

  if (!empty($_COOKIE['id_value'])) {
    try {
        $stmt = $db->prepare("UPDATE cost SET item_type = ?, price_per_unit = ?, item_name = ? WHERE item_id = ?");
        $stmt->execute([$_POST['type'], $_POST['price'], $_POST['item'], $_COOKIE['id_value']]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
    setcookie('id_value','', 10000,'/');
} else {
    try {
        $stmt = $db->prepare("INSERT INTO cost (item_name, item_type, price_per_unit) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['item'], $_POST['type'], $_POST['price']]);
    } catch (PDOException $ex) {
        print('Error : ' . $ex->getMessage());
        exit();
    }
}
setcookie('save','1');
header('Location: ../Tables/CostTable.php');
}
