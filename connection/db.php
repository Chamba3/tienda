<?php
$servername = "sql5.freesqldatabase.com";
$username = "sql5666947";
$password = "atbTSNfthV";
$dbname = "sql5666947";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
