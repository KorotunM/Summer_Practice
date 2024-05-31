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
    $sth = $db->prepare("SELECT*FROM cost");
    $sth->execute();
    $cost = $sth->fetchAll();
    ?>

    <h2>Таблица затрат по канцтоварам</h2>
    <table class="tableD">
        <tr>
            <th>ID_Канцтовара</th>
            <th>Название канцтовара</th>
            <th>Единица измерения</th>
            <th>Цена за единицу</th>
        </tr>
        <?php
        foreach ($cost as $c) {
            printf('
      <tr>
      <td>%d</td>
      <td>%s</td>
      <td>%s</td>
      <td>%s</td>
      <td class="action">
        <form class = "actionform" action="../Listeners/CostListener.php" method="POST">
          <input type="hidden" name="item_id" value= %d >
          <input type="hidden" name="item" value= "%s" >
          <input type="hidden" name="type" value="%s">
          <input type="hidden" name="price" value="%s">
          <input type="submit" name="change" class="tableButtonCh" value="изменить"/>
          <input type="submit" name="delete" class="tableButtonDel" value="удалить"/>
        </form>
      </td>
      </tr>',
                $c['item_id'],
                $c['item_name'],
                $c['item_type'],
                $c['price_per_unit'],
                $c['item_id'],
                $c['item_name'],
                $c['item_type'],
                $c['price_per_unit']
            );
        }
        ?>
    </table>
    <form action="../Index/CostIndex.php" method="GET">
        <input class="AddBut" type="submit" value="Добавить" />
    </form>
</body>
</html>