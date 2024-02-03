<?php

    session_start() ;
    if (isset($_SESSION['username'])){
        session_destroy();
    }
    header("Location: http://localhost/krishna/index.php");
    exit();
?>