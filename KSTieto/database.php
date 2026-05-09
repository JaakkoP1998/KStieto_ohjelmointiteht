<?php

    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    // Tietokanta johon yhdistetään.
    $db_name = "kstietodb";
    $conn = "";

    try {
        $conn = mysqli_connect($db_server,
                                $db_user, 
                                $db_password, 
                                $db_name);
    } catch (mysqli_sql_exception){
        echo"Could not connect to database.";
    }
    

    /*
    if ($conn){
        echo"You are connected!";
    } 
    */
?>