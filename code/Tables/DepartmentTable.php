<?php
if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    print ('<div class="message">Изменение произошло успешно</div><br>');
}
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', 100000, '/');
}
setcookie('id_value', '', 100000, '/');
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
        <li><a href="CostTable.php">⚡️ Список затрат</a></li>
        <li><a href="DepartmentTable.php">⚡️ Список департаментов</a></li>
        <li><a href="EmployeeTable.php">⚡️ Список cотрудников</a></li>
        <li><a href="OfficeLogTable.php">⚡️ Журнал расхода канцтоваров</a></li>
    </ul>

    <?php
    include ('../password.php');
    $sth = $db->prepare("SELECT*FROM department");
    $sth->execute();
    $department = $sth->fetchAll();
    ?>

    <h2>Таблица департаментов</h2>
    <table class="tableD">
        <tr>
            <th>ID_Департамаента</th>
            <th>Название департамента</th>
            <th>ФИО руководителя</th>
            <th>Адрес</th>
        </tr>
        <?php
        foreach ($department as $dept) {
            printf('
      <tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td class="action">
        <form class = "actionform" action="../Listeners/DepartmentListener.php" method="POST">
          <input type="hidden" name="department_id" value= %d >
          <input type="hidden" name="department_name" value= "%s" >
          <input type="hidden" name="fio" value="%s">
          <input type="hidden" name="adres" value="%s">
          <input type="submit" name="change" class="tableButtonCh" value="изменить"/>
          <input type="submit" name="delete" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>',
                $dept['department_id'],
                $dept['department_name'],
                $dept['manager_name'],
                $dept['adres'],
                $dept['department_id'],
                $dept['department_name'],
                $dept['manager_name'],
                $dept['adres']
            );
        }
        ?>
    </table>
    <form action="../Index/DepartmentIndex.php" method="GET">
        <input class="AddBut" type="submit" value="Добавить" />
    </form>
</body>

</html>