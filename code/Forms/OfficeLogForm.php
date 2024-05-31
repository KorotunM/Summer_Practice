<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Летняя практика</title>
    <link rel="stylesheet" href="../Forms/style2.css">
</head>

<body>
    <form action="../Index/OfficeLogIndex.php" method="POST">
        <h2>Журнал отчёта</h2>
        <label>
            <h5>Выберите сотрудника, внёсшего изменения:</h5><br />
            <?php
            include ('../password.php');
            $sth = $db->prepare("SELECT DISTINCT fio, employee_id FROM employee");
            $sth->execute();
            $employee = $sth->fetchAll();
            ?>
            <select name="employee" <?php if ($errors['employee']) {
                print 'class="error"';
            } ?>>
                <?php
                foreach ($employee as $emp) {
                    printf('
          <option %s value = "%d" >%s</option>',
                        $emp['fio'] == $values['employee'] ? 'selected' : '',
                        $emp['employee_id'],
                        $emp['fio']
                    );
                }
                ?>
            </select>
        </label><br />
        <?php if ($errors['employee']) {
            print ($messages['employee']);
            print ('<br>');
        } ?>

        <label>
            <h5>Выберите канцтовар из предложенного списка:</h5><br />
            <?php
            include ('../password.php');
            $sth = $db->prepare("SELECT DISTINCT item_name, item_id FROM cost");
            $sth->execute();
            $item = $sth->fetchAll();
            ?>
            <select name="item" <?php if ($errors['item']) {
                print 'class="error"';
            } ?>>
                <?php
                foreach ($item as $it) {
                    printf('
          <option %s value = "%d" >%s</option>',
                        $it['item_name'] == $values['item'] ? 'selected' : '',
                        $it['item_id'],
                        $it['item_name']
                    );
                }
                ?>
            </select>
        </label><br />
        <?php if ($errors['item']) {
            print ($messages['item']);
            print ('<br>');
        } ?>

        <label>
            <h5>Введите количество:</h5><br />
            <input name="quantity" type="number" <?php if ($errors['quantity']) {
                print 'class="error"';
            } ?>
                value="<?php print $values['quantity']; ?>" placeholder="Количество" />
        </label><br />
        <?php if ($errors['quantity']) {
            print ($messages['quantity']);
            print ('<br>');
        } ?>

        <label>
            <h5> Укажите цель расходов канцтоваров: </h5><br />
            <input name="purpose" type="text" <?php if ($errors['purpose']) {
                print 'class="error"';
            } ?>
                value="<?php print $values['purpose'] ?>" placeholder="Цель" />
        </label>
        <?php if ($errors['purpose']) {
            print ($messages['purpose']);
            print ('<br>');
        } ?>

        <input class="SaveBut" type="submit" value="Сохранить" />
    </form>
</body>

</html>