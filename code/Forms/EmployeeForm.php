<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Летняя практика</title>
  <link rel="stylesheet" href="../Forms/style2.css">
</head>

<body>
<form action="../Index/EmployeeIndex.php" method="POST">
    <h2>Форма cотрудника</h2>
    <label>
      <h5>Введите ваше ФИО:</h5><br />
      <input name="fio" type = "text" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="ФИО" />
    </label><br />
    <?php if ($errors['fio']) {print($messages['fio']); print('<br>');}?>

    <label>
      <h5>Введите телефон:</h5><br />
      <input name="tel" type="tel" <?php if ($errors['tel']) {print 'class="error"';} ?> value="<?php print $values['tel']; ?>" placeholder="номер" />
    </label><br />
    <?php if ($errors['tel']) {print($messages['tel']); print('<br>');}?>

    <label>
      <h5>Введите email:</h5><br />
      <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" placeholder="почта" />
    </label><br />
    <?php if ($errors['email']) {print($messages['email']); print('<br>');}?>

    <label>
      <h5>Введите занимаемую, должность: </h5><br />
      <input name = "position" type = "text" <?php if($errors['position']){print 'class="error"';} ?> value = "<?php print $values['position']?>" placeholder="должность" />
    </label>
    <?php if($errors['position']) {print($messages['position']); print('<br>');} ?>

    <label>
      <h5> Выберите департамент cотрудника: </h5><br />
      <?php
      include('../password.php');
      $sth=$db->prepare("SELECT DISTINCT department_name, department_id FROM department");
      $sth->execute();
      $department = $sth->fetchAll();
      ?>
      <select name="department"  <?php if ($errors['department']) {print 'class="error"';} ?> >
      <?php
      foreach($department as $dept){
        printf('
          <option %s value = "%d" >%s</option>'
          , $dept['department_name'] == $values['department'] ?  'selected' : '', $dept['department_id'], $dept['department_name']
        );
      }
      ?>
      </select>
      <?php if ($errors['department']) {print($messages['department']); print('<br>');}?>
    </label>

    <input class = "SaveBut" type="submit" value="Сохранить" />
  </form>
</body>

</html>