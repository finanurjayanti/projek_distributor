<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    $isAdmin = $controller->isAdmin($data["username"], $data["password"]);

    if ($isAdmin == "1") {
        echo $controller->setSession();
        return;
    }

    echo $isAdmin;
}
?>