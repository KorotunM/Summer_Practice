<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include ('../password.php');
    if (isset($_POST['change'])) {
        setcookie('id_value', $_POST['id'], time() + 24 * 60 * 60, '/');
        setcookie('item_value', $_POST['item'], time() + 24 * 60 * 60, '/');
        setcookie('employee_value', $_POST['employee'], time() + 24 * 60 * 60, '/');
        setcookie('quantity_value', $_POST['quantity'], time() + 24 * 60 * 60, '/');
        setcookie('purpose_value', $_POST['purpose'], time() + 24 * 60 * 60, '/');
        header('Location: ../Index/OfficeLogIndex.php');
    } elseif (isset($_POST['delete'])) {
        try {
            include ('../password.php');
            $id_off = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM office_log where id = ?");
            $stmt->execute([$id_off]);
        } catch (PDOException $e) {
            print ('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: ../Tables/OfficeLogTable.php');
    }
}