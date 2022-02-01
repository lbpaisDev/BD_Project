<?php
function OpenCon()
{
    //Connection properties
    $dbhost = "localhost";
    $dbuser = "pedro";
    $dbpass = "pedro";
    $db = "bd_project";


    //Make the connection
    //Die catches a connection error 
    $conn = new mysqli(
        $dbhost,
        $dbuser,
        $dbpass,
        $db
    );

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function CloseCon($conn)
{
    $conn->close();
}