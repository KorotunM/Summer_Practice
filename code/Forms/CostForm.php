<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Летняя практика</title>
    <link rel="stylesheet" href="../Forms/style2.css">
</head>

<body>
    <form action="../Index/CostIndex.php" method="POST">
        <h2>Форма указания стоимости единицы канцтовара </h2>
        <label>
            <h5>Введите название канцтовара:</h5><br />
            <input name="item" type="text" <?php if ($errors['item']) {
                print 'class="error"';
            } ?>
                value="<?php print $values['item']; ?>" placeholder="Название" />
        </label><br />
        <?php if ($errors['item']) {
            print ($messages['item']);
            print ('<br>');
        } ?>

        <label>
            <h5>Укажите единицу измерения канцтовара: </h5><br />
            <select name="type" <?php if ($errors['type']) {
                print 'class="error"';
            } ?>>
                <option <?php echo $values['type'] == 'кг' ? 'selected' : '' ?> value="кг">кг</option>
                <option <?php echo $values['type'] == 'шт' ? 'selected' : '' ?> value="шт">шт</option>
                <option <?php echo $values['type'] == 'гр' ? 'selected' : '' ?> value="гр">гр</option>
            </select>
        </label><br />
        <?php if ($errors['type']) {
            print ($messages['type']);
            print ('<br>');
        } ?>

        <label>
            <h5>Введите цену за единицу продукта: </h5><br />
            <input name="price" type="number" step="0.1" <?php if ($errors['price']) {
                print 'class="error"';
            } ?>
                value="<?php print $values['price'] ?>" placeholder="Цена" />
        </label><br />
        <?php if ($errors['price']) {
            print ($messages['price']);
            print ('<br>');
        } ?>

        <input class="SaveBut" type="submit" value="Сохранить" />
    </form>
</body>

</html>