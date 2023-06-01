<?php
//this page contains the database information in order to connect to it. This is done so I cant just include this page instead of entering the information every time.
function connectDb()
{
    $servername = "localhost:3308";
    $user = 'root';
    $pass = 'A07102000a';
    $dbname = 'testdb';
    $conn = new mysqli($servername, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    return $conn;
}
$conn = connectDb();