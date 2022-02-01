<?php
/**
 * Cria uma connecção com a database
 * @return mysqli
 */
function OpenCon(){
    //Connection properties
    $dbhost = "localhost";
    $dbuser = "pedro";
    $dbpass = "pedro";
    $db = "bd_project";

    //Make the connection
    //Die catches a connection error
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

    return $conn;
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}


function fnx($page) {
    header("location: " . $page);
}

function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}