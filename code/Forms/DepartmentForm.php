<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Летняя практика</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
<form action="../Index/DepartmentIndex.php" method="POST">
    <h2>Форма Департамента</h2>
    <label>
      <h5>Введите название департамента:</h5><br />
      <input name="department" type = "text" <?php if ($errors['department']) {print 'class="error"';} ?> value="<?php print $values['department']; ?>" placeholder="Название" />
    </label><br />
    <?php if ($errors['department']) {print($messages['department']); print('<br>');}?>

    <label>
      </h5>Введите ФИО рукводитеоя: </h5><br />
      <input name = "fio" type = "text" <?php if($errors['fio']){print 'class="error"';} ?> value = "<?php print $values['fio']?>" placeholder="ФИО" />
    </label><br />
    <?php if($errors['fio']) {print($messages['fio']); print('<br>');} ?>
    
    <label>
      </h5>Введите адрес расположения департамента: </h5><br />
      <input name = "adres" type = "text" <?php if($errors['adres']){print 'class="error"';} ?> value = "<?php print $values['adres']?>" placeholder="Адрес" />
    </label><br />
    <?php if($errors['adres']) {print($messages['adres']); print('<br>');} ?>

    <input class = "SaveBut" type="submit" value="Сохранить" />
  </form>
</body>

</html>