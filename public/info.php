<?php
$mysqli = new mysqli('database-1.cl6ae4usifnd.eu-north-1.rds.amazonaws.com', 'admin', 'Ahmed#123', 'database-1');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
} else {
    echo "Connected successfully!";
}

$mysqli->close();
?>

