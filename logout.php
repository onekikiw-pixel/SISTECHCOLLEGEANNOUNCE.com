<?php
require_once 'helpers.php';
session_unset();
session_destroy();
header('Location: index.php');
exit;
?>