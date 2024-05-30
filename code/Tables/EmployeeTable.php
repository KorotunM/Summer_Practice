

<?php
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        print('<div class="message">Изменение произошло успешно</div><br>');
    }
    foreach($_COOKIE as $key => $value) {
        setcookie($key, '', 100000, '/');
    }
    setcookie('id_value','', 100000, '/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Летняя практика</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<ul>
    <li><a href="CostTable.php">Список затрат</a></li>
    <li><a href="DepartmentTable.php">Список Сотрудников</a></li>
    <li><a href="EmployeeTable.php">Журнал расхода канцтоваров</a></li>
    <li><a href="OfficeLogTable.php">Список канцтоваров</a></li>
</ul>

<?php 
include('../password.php');
$sth = $db->prepare("SELECT*FROM employee");
$sth->execute();
$employee = $sth->fetchAll();
?>

<h2>Таблица Сотрудников</h2>
<table class="employee">
  <tr>
    <th>ID_Сотрудника</th>
    <th>ID_Департамаента</th>
    <th>ФИО</th>
    <th>Телефон</th>
    <th>Email</th>
    <th>Должность</th>
    <th class="action"></th>
  </tr>
  <?php
    foreach($employee as $emp) {
      $sth = $db->prepare("SELECT*FROM department");
      $sth->execute();
      $dept = $sth->fetchAll();
      foreach($dept as $d){
      if($emp['department_id'] == $d['department_id']){ $department_name = $d['department_name']; print($department_name);break;}
      }
      printf('
      <tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td class="action">
        <form class = "actionform" action="../Listeners/EmployeeListener.php" method="POST">
          <input type="hidden" name="employee_id" value= %d >
          <input type="hidden" name="department_name" value= %s >
          <input type="hidden" name="fio" value="%s">
          <input type="hidden" name="tel" value="%s">
          <input type="hidden" name="email" value="%s">
          <input type="hidden" name="position" value="%s">
          <input type="submit" name="change" class="tableButtonCh" value="изменить"/>
          <input type="submit" name="delete" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>',
      $emp['employee_id'], $department_name, $emp['fio'], $emp['tel'],
      $emp['email'], $emp['position'], $emp['employee_id'], $department_name,
      $emp['fio'], $emp['tel'], $emp['email'], $emp['position']);
    }
  ?>
</table>
<form action="../Index/EmployeeIndex.php" method="GET">
<input class = "AddBut" type="submit" value="Добавить" />
</form>
</body>
</html>


