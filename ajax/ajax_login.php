<?php
session_start();

$nome_usuario = isset($_POST["nome_usuario"]) ? $_POST["nome_usuario"] : '';
$senha = isset($_POST["senha"]) ? $_POST["senha"] : '';

if (empty($nome_usuario) || empty($senha)) {
    echo "2";
    die();
}

$link = mysqli_connect("localhost", "root", "", "database");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    die();
}

$query = "
    SELECT
        id,
        nome,
        nome_usuario,
        senha
    FROM
        funcionarios
    WHERE TRUE
        AND nome_usuario = '{$nome_usuario}'
        AND senha = '{$senha}'
";

if ($result = mysqli_query($link, $query)) {
    $row = mysqli_fetch_assoc($result);
}
$row_cnt = $result->num_rows;

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

if ($row_cnt == "1") {
    $_SESSION["id_usuario"] = $row["id"];
    $_SESSION["nome_usuario"] = $row["nome_usuario"];
    $_SESSION["nome"] = $row["nome"];
    echo "1";
} else {
    echo "-1";
}

mysqli_close($link);
