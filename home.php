<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id_usuario'];

$link = mysqli_connect("localhost", "root", "", "database");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    die();
}

$query = "
    SELECT
    	status_ponto,
    	hora 
    FROM
    	registro_ponto 
    WHERE TRUE 
    	AND fk_usuario = '{$id}' 
    ORDER BY
    	hora DESC 
    	LIMIT 1
";

$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);
if (isset($row)) {
    $status = $row['status_ponto'];
    $data = $row['hora'];

    if ($status == '1') {
        $status_desc = 'entrada';
        $dis_entrada = 'disabled';
        $dis_saida = '';
    } else {
        $status_desc = 'saida';
        $dis_entrada = '';
        $dis_saida = 'disabled';
    }

    $hora_x    = substr($data, 11, 2);
    $minuto_x  = substr($data, 14, 2);
    $segundo_x = substr($data, 17, 2);
    $horario  = "$hora_x:$minuto_x:$segundo_x";
    $dia = date("d/m/Y", strtotime($data));
} else {
    $dis_entrada = '';

    $dis_saida = 'disabled';
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        Sucesso
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-dark">
    <div class="mt-5 container">
        <div class="row justify-content-center text-center">
            <div class="mt-8">
                <div class="font-weight-bolder text-success lead mt-8">
                    <h1><?php echo 'Bem vindo ' . $_SESSION['nome_usuario'] . '!'; ?></h1>
                </div>
                <?php if (isset($row)) { ?>
                    <div class="text-light mb-3">Seu último registro foi de <?php echo $status_desc; ?> dia <?php echo $dia; ?> às <?php echo $horario; ?>hs</div>
                <?php } ?>

                <button class="btn btn-lg btn-success btn-block ponto" id="entrada" type="submit" value="1" <?php echo $dis_entrada; ?>>Registrar entrada</button>
                <button class="btn btn-lg btn-danger btn-block ponto" id="saida" type="submit" value="0" <?php echo $dis_saida; ?>>Registrar saída</button>

                <div id="resultAjax" class="text-center mt-5 mb-3 text-primary"></div>

                <?php if ($_SESSION["id_usuario"] == '1') { ?>
                    <a href="relatorio_ponto.php" class="btn btn-lg btn-success btn-block btn-info">Relatório Ponto</a>
                <?php } ?>

                <div class="mt-5 text-center text-white">
                    <a href="logout.php" class="mt-5 font-weight-bolder btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <script>
        $(document).ready(function() {

            $('.ponto').off('click').on('click', function() {
                let _this = $(this);
                let textButton = _this.text();
                let status = _this.val();

                $('#resultAjax').html('');

                _this.text('Aguarde');
                _this.attr('disabled', 'disabled');

                $('#resultAjax').load('./ajax/ajax_ponto.php', {
                    status: status
                }, function(retorno) {
                    _this.removeAttr('disabled');
                    _this.text(textButton);

                    if (retorno == '1') {
                        Swal.fire({
                            title: 'Registro realizado com sucesso!',
                            text: "Não esqueça de sair da sua conta",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            location.reload();
                        })
                    } else {
                        document.getElementById('resultAjax').innerHTML = 'Erro.';
                    }

                });
            });

        });
    </script>

</body>

</html>