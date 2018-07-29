<?php

session_start();

unset($_SESSION['admin_logged_in']);

unset($_SESSION['emp_logged_in']);

session_destroy();


header("Location: login.php");


?>
