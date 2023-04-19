<?php
session_start();

$nome = isset($_POST["nome"]) ? $_POST["nome"] : '';
$nome_usuario = isset($_POST["nome_usuario"]) ? $_POST["nome_usuario"] : '';
$senha = isset($_POST["senha"]) ? $_POST["senha"] : '';
$confirma_senha = isset($_POST["confirma_senha"]) ? $_POST["confirma_senha"] : '';

if (empty($nome_usuario) || empty($nome_usuario) || empty($senha) || empty($confirma_senha)) {
    echo "2";
    die();
}

if ($senha != $confirma_senha) {
    echo "3";
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
        nome
    FROM
        funcionarios
    WHERE TRUE
        AND nome = '{$nome}'
";

if ($result = mysqli_query($link, $query)) {
    $row = mysqli_fetch_assoc($result);
}
$row_cnt = $result->num_rows;

if ($row_cnt == "1") {
    die('4');
}

$query = "
    SELECT
        nome_usuario
    FROM
        funcionarios
    WHERE TRUE
        AND nome_usuario = '{$nome_usuario}'
";

if ($result = mysqli_query($link, $query)) {
    $row = mysqli_fetch_assoc($result);
}
$row_cnt = $result->num_rows;

if ($row_cnt == "1") {
    die("5");
}

$query = "
    INSERT INTO funcionarios ( nome, nome_usuario, senha ) VALUES( '{$nome}', '{$nome_usuario}', '{$senha}' )
";

if ($result = mysqli_query($link, $query)) {
    echo "1";
}

mysqli_close($link);
