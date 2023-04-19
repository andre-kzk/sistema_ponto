<?php
session_start();

if ($_SESSION["id_usuario"] != '1') {
    header("Location: logout.php");
    exit;
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
    	nome 
    FROM
    	funcionarios 
    WHERE TRUE 
    	AND ativo = 1 
    ORDER BY
    	nome ASC
";

$results = mysqli_query($link, $query);
$funcionarios = array();
while ($row = mysqli_fetch_assoc($results)) {
    $funcionarios[] = $row;
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        Relatório horas trabalhadas
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body class="bg-dark">
    <div class="mt-3 container">
        <div class="row justify-content-center text-center">
            <div>
                <div class="form-signin  text-center">
                    <div class="text-center font-weight-bolder text-success lead my-5">
                        <h1>Relatório horas trabalhadas.</h1>
                    </div>
                    <form>
                        <div class="form-group">
                            <select class="form-control" id="funcionario">
                                <?php foreach ($funcionarios as $funcionario) {
                                    echo "<option value='" . $funcionario['id'] . "'>" . $funcionario['nome'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <label class="text-light" for="data">Período de:</label>
                        <input id="data_inicial" type="text" class="form-control datepicker" data-provide="datepicker" name="data" placeholder="Selecione a data inicial">
                        <label class="text-light" for="data">Até:</label>
                        <input id="data_final" type="text" class="form-control datepicker mb-3" data-provide="datepicker" name="data" placeholder="Selecione a data final">
                    </form>

                    <button class="btn btn-lg btn-primary mb-3" id="carregar">Carregar página</button>
                    <div id="load"></div>

                    <div class="mt-5 text-center text-white">
                        <a href="index.php" class="mt-3 font-weight-bolder btn btn-danger">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            });


            $("#carregar").click(function() {
                let id = $('#funcionario').val();
                let data_inicial = $('#data_inicial').val();
                let data_final = $('#data_final').val();

                $("#load").load("relatorio_ponto_load.php?id=" + id + "&data_inicial=" + data_inicial + "&data_final=" + data_final);
            });


        });
    </script>

</body>

</html>