<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    $errors = array();
    $errors['employee'] = !empty($_COOKIE['employee_error']);
    $errors['item'] = !empty($_COOKIE['item_error']);
    $errors['quantity'] = !empty($_COOKIE['quantity_error']);
    $errors['purpose'] = !empty($_COOKIE['purpose_error']);

    if ($errors['employee']) {
        setcookie('employee_error', '', 100000);
        setcookie('employee_value', '', 100000);
        $messages['employee'] = '<div class="error">Выберите сотрудника.</div>';
    }
    if ($errors['item']) {
        setcookie('item_error', '', 100000);
        setcookie('item_value', '', 100000);
        $messages['item'] = '<div class="error"> Выберите канцтовар.</div>';
    }
    if ($errors['quantity']) {
        setcookie('quantity_error', '', 100000);
        setcookie('quantity_value', '', 100000);
        $messages['quantity'] = '<div class="error"> Укажите количество. </div>';
    }
    if ($errors['purpose']) {
        setcookie('purpose_error', '', 100000);
        setcookie('purpose_value', '', 100000);
        $messages['purpose'] = '<div class="error"> Заполните цель расходов, доступные символы: буквы русского и английского алфавита, а также цифры, точка, запятая и тире </div>';
    }


    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', 100000);
    }

    $values = array();
    $values['employee'] = empty($_COOKIE['employee_value']) ? '' : strip_tags($_COOKIE['employee_value']);
    $values['item'] = empty($_COOKIE['item_value']) ? '' : strip_tags($_COOKIE['item_value']);
    $values['quantity'] = empty($_COOKIE['quantity_value']) ? '' : strip_tags($_COOKIE['quantity_value']);
    $values['purpose'] = empty($_COOKIE['purpose_value']) ? '' : strip_tags($_COOKIE['purpose_value']);
    include ('../Forms/OfficeLogForm.php');
} else {
    include ('../password.php');
    $errors = FALSE;
    if (empty($_POST['employee'])) {
        setcookie('employee_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('employee_value', $_POST['employee'], time() + 12 * 30 * 24 * 60 * 60);

    if (empty($_POST['item'])) {
        setcookie('item_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('item_value', $_POST['item'], time() + 12 * 30 * 24 * 60 * 60);

    if (empty($_POST['quantity']) || !preg_match('/^[0-9]+([.,][0-9]{1,2})?$/', $_POST['quantity'])) {
        setcookie('quantity_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('quantity_value', $_POST['quantity'], time() + 12 * 30 * 24 * 60 * 60);

    $pattern = '/^[\p{Cyrillic}A-Za-z0-9.,.,\s\-]+$/u';
    if (empty($_POST['purpose']) || !preg_match($pattern, $_POST['purpose'])) {
        setcookie('purpose_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('purpose_value', $_POST['purpose'], time() + 12 * 30 * 24 * 60 * 60);

    if ($errors) {
        header('Location: OfficeLogIndex.php');
        exit();
    } else {
        setcookie('employee_error', '', 100000);
        setcookie('item_error', '', 100000);
        setcookie('quantity_error', '', 100000);
        setcookie('purpose_error', '', 100000);
    }

    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', 100000);
    }
    if (!empty($_COOKIE['id_value'])) {
        $employee_id = $_POST['employee'];
        $item_id = $_POST['item'];
        try {
            $stmt = $db->prepare("UPDATE office_log SET item_id = ?, employee_id = ?, quantity = ?, purpose = ? WHERE id = ?");
            $stmt->execute([$item_id, $employee_id, $_POST['quantity'], $_POST['purpose'], $_COOKIE['id_value']]);
        } catch (PDOException $ex) {
            print ('Error : ' . $ex->getMessage());
            exit();
        }
        setcookie('id_value', '', 10000, '/');
    } else {
        $employee_id = $_POST['employee'];
        $item_id = $_POST['item'];
        try {
            $stmt = $db->prepare("INSERT INTO employee (item_id, employee_id, quantity, purpose) VALUES (?, ?, ?, ?)");
            $stmt->execute([$item_id, $employee_id, $_POST['quantity'], $_POST['purpose']]);
        } catch (PDOException $ex) {
            print ('Error : ' . $ex->getMessage());
            exit();
        }
    }
    setcookie('save', '1');
    header('Location: ../Tables/OfficeLogTable.php');

}
