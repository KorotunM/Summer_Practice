<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../password.php');
    if (isset($_POST['change'])) {
        setcookie('id_value', $_POST['department_id'], time() + 24 * 60 * 60, '/');
        setcookie('department_value',$_POST['department_name'], time() + 24 * 60 * 60, '/');
        setcookie('fio_value',$_POST['fio'], time() + 24 * 60 * 60, '/');
        setcookie('adres_value',$_POST['adres'], time() + 24 * 60 * 60, '/');
        header('Location: ../Index/DepartmentIndex.php');
    }
    elseif (isset($_POST['delete'])) {
        try {
            $id_dept = $_POST['department_id'];
            $stmt = $db->prepare("DELETE FROM department where department_id = ?");
            $stmt->execute([$id_dept]);
            $stmt = $db->prepare("DELETE FROM employee WHERE department_id = ?");
            $stmt->execute([$id_dept]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: ../Tables/DepartmentTable.php');
    }
}