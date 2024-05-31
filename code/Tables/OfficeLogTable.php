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
    $sth = $db->prepare("SELECT*FROM office_log");
    $sth->execute();
    $office_log = $sth->fetchAll();
    ?>

    <h2>Журнал учёта</h2>
    <table class="tableD">
        <tr>
            <th>ID</th>
            <th>Название канцтовара</th>
            <th>ФИО Сотрудника, внёсшего изменение</th>
            <th>Количество</th>
            <th>Цель рассходов</th>
        </tr>
        <?php
        foreach ($office_log as $ofl) {
            $sth = $db->prepare("SELECT*FROM employee");
            $sth->execute();
            $employee = $sth->fetchAll();
            foreach ($employee as $emp) {
                if ($ofl['employee_id'] == $emp['employee_id']) {
                    $employee_name = $emp['fio'];
                    break;
                }
            }
            $sth = $db->prepare("SELECT*FROM cost");
            $sth->execute();
            $cost = $sth->fetchAll();
            foreach ($cost as $c) {
                if ($c['item_id'] == $ofl['item_id']) {
                    $item_name = $c['item_name'];
                    break;
                }
            }
            printf('
      <tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%d</td>
      <td>%s</td>
      <td class="action">
        <form class = "actionform" action="../Listeners/OfficeLogListener.php" method="POST">
          <input type="hidden" name="id" value= %d >
          <input type="hidden" name="item" value= "%s" >
          <input type="hidden" name="employee" value="%s">
          <input type="hidden" name="quantity" value=%d>
          <input type="hidden" name="purpose" value="%s">
          <input type="submit" name="change" class="tableButtonCh" value="изменить"/>
          <input type="submit" name="delete" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>',
                $ofl['id'],
                $item_name,
                $employee_name,
                $ofl['quantity'],
                $ofl['purpose'],
                $ofl['id'],
                $item_name,
                $employee_name,
                $ofl['quantity'],
                $ofl['purpose']
            );
        }
        ?>
    </table>
    <form action="../Index/OfficeLogIndex.php" method="GET">
        <input class="AddBut" type="submit" value="Добавить" />
    </form>
</body>

</html>