<?php

    require_once("config/database.config.php");

    if (isset($_GET["id"])){
        $id = $_GET["id"];

        $sql = "DELETE FROM booking WHERE id = $id";

        if ($dbc->query($sql)) {
            printf("Record deleted successfully.<br />");
            header("Location: http://localhost/krishna/index.php");
         }
         if ($dbc->errno) {
            printf("Could not delete record from table: %s<br />", $dbc->error);
         }

    }else{
        header("Location: http://localhost/krishna/index.php");
    }


?>