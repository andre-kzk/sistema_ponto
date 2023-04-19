<?php
session_start();

$status = isset($_POST["status"]) ? $_POST["status"] : '';
$id_usuario = $_SESSION['id_usuario'];

if (!isset($status)) {
    die('2');
}

$link = mysqli_connect("localhost", "root", "", "database");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    die();
}

$query = "
    INSERT INTO registro_ponto ( fk_usuario, status_ponto ) VALUES( '{$id_usuario}', '{$status}' )
";

if ($result = mysqli_query($link, $query)) {
    echo "1";
}

mysqli_close($link);
