<?php
include "src/Controller.php";

$cookie = $_COOKIE;
$sessionid = $cookie["sessionid"];

if ($sessionid == "") {
    header("Location: login.php");
} else {
    $isSession = $controller->isSession($sessionid);
    
    if ($isSession == 0) {
        header("Location: login.php");
    }
}
?>