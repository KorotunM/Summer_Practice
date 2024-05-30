<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../password.php');
    if (isset($_POST['change'])) {
        setcookie('id_value', $_POST['item_id'], time() + 24 * 60 * 60, '/');
        setcookie('item_value',$_POST['item'], time() + 24 * 60 * 60, '/');
        setcookie('type_value',$_POST['type'], time() + 24 * 60 * 60, '/');
        setcookie('price_value',$_POST['price'], time() + 24 * 60 * 60, '/');
        header('Location: ../Index/CostIndex.php');
    }
    elseif (isset($_POST['delete'])) {
        try {
            $id_item = $_POST['item_id'];
            $stmt = $db->prepare("DELETE FROM cost where item_id = ?");
            $stmt->execute([$id_item]);
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }
        setcookie('save', '1');
        header('Location: ../Tables/CostTable.php');
    }
}