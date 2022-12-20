<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;
    $isSession = $controller->isSession($data["sessionid"]);

    echo $isSession;
}
?>