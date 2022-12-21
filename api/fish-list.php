<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode($controller->getAllFish());
}
?>