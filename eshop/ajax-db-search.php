<?php
require_once "eshopfunctions.php";

if (isset($_POST['term'])) {

  $pdo = connectPDO();
    $term = $_POST['term'] . '%';

    $query = "SELECT Produktnamn FROM produkter WHERE Produktnamn LIKE ? LIMIT 25";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$term]);
    
    $res = [];
    while ($row = $stmt->fetch()) {
        $res[] = $row['Produktnamn'];
    }

    echo json_encode($res);
}

echo "ok"
?>