<?php
session_start();


if (isset($_SESSION['valid_email']) && isset($_SESSION['valid_password'])) {
    
    session_unset();

    
    session_destroy();
}


header("Location: index.php");
exit();
?>
