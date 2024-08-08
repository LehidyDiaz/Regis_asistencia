<?php
include("configGoog.php");

$google_client->revokeToken();

session_unset();

session_destroy();

header("Location: goog.php");

exit(); 