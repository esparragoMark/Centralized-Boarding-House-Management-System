<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "hausmaster_db";

    //Creating database connection

    $con = mysqli_connect($host, $username , $password , $database);

    if(!$con){

        die("Connection Fieled: ". mysqli_connect_error());

    }

?>