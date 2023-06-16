<?php

require_once "class.php";
$response = array();
session_start();
if (isset($_GET["email"])) {
    $result=Access::checkEmail($_GET["email"]);
    if (isset($result)) {
        $response["trovato"] = true;
    }
    else
    {
        $response["trovato"] = false;
    }
}
if (isset($_GET["user"])) {
    $result="";
    $result=Access::checkUsern($_GET["user"]);
    
    if (isset($result)) {
        $response["trovato"] = true;
    }
    else
    {
        $response["trovato"] = false;
    }
}
echo json_encode($response);
?>
