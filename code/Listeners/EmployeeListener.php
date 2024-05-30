<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../password.php');
    if (isset($_POST['change'])) {
      setcookie('id_value', $_POST['employee_id'], time() + 24 * 60 * 60, '/');
      setcookie('department_value', $_POST['department_name'], time() + 24 * 60 * 60, '/');
      $stmt = $db->prepare("SELECT fio, tel, email, position FROM employee WHERE employee_id = ?");
      $stmt->execute([$_POST['employee_id']]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      setcookie('fio_value', $result[0]['fio'], time() + 24 * 60 * 60, '/');
      setcookie('tel_value', $result[0]['tel'], time() + 24 * 60 * 60, '/');
      setcookie('email_value', $result[0]['email'], time() + 24 * 60 * 60, '/');
      setcookie('position_value', $result[0]['position'], time() + 24 * 60 * 60, '/');
      header('Location: ../Index/EmployeeIndex.php');
    }
    elseif (isset($_POST['delete'])) {
        try {
            include('../password.php');
            $id_emp = $_POST['employee_id'];
            $stmt = $db->prepare("DELETE FROM employee where employee_id = ?");
            $stmt->execute([$id_emp]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: ../Tables/EmployeeTable.php');
    }
}