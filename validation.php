<?php
// include("db.php");
session_start();
if (!isset($_SESSION["user"])) {
    if (!isset($_SESSION["user_email_address"])) {
        header("Location: index.php");
    } else {
    }
}
?>