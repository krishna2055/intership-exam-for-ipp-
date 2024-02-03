<?php
    define('DB_USER', 'root'); 
    define('DB_PASSWORD', ''); 
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'krishna'); 

    // make a connection
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die ('Unable to connect to MySQL: ' . mysqli_connect_error());

    function escape_data($data){
        if(ini_get('magic_quotes_gpc')){
            $data = stripslashes($data);
        }

        global $dbc;
        $data = mysqli_real_escape_string($dbc, trim($data));
        return $data;
    }

?>