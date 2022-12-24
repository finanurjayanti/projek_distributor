<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    echo $controller->addTransaction($data["fishId"], $data["name"], $data["type"], $data["value"]);
}
?>