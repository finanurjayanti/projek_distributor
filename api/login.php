<?php
include "../src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;
    
    $isAdmin = $controller->isAdmin($data["username"], $data["password"]);

    if ($isAdmin) {
        $controller->setSession();
    }

    echo "<script>console.log($isAdmin)</script>";
    return $isAdmin;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "METHOD NOT ALLOWED!";
}
?>