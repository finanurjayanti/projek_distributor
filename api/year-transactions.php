<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $transactions = $controller->getYearTransactions();

    echo json_encode($transactions);
}
?>