<?php
session_start();
$is_auth = 1;

if (!isset($_SESSION["$is_auth"])){
    $is_auth = 1;
}

$_SESSION["$is_auth"] = $is_auth;
