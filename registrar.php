<?php
session_start();

if (isset($_SESSION["id_usuario"])) {
    header("Location: logout.php");
    exit;
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        Registrar
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="bg-dark">
    <div class="mt-5 container">
        <div class="row justify-content-center text-center">
            <div class="mt-8">
                <div class="form-signin  text-center">
                    <div class="text-center font-weight-bolder text-success lead my-5">
                        <h1>Registro de funcionário.</h1>
                    </div>

                    <input type="text" id="nome" name="nome" class="form-control text-center mb-2" placeholder="Nome completo" required autofocus>
                    <input type="text" id="nome_usuario" name="nome_usuario" class="form-control text-center mb-2" placeholder="Nome de usuário" required autofocus>
                    <input type="password" id="senha" name="senha" class="form-control text-center mb-2" placeholder="Digite uma senha" required autofocus>
                    <input type="password" id="confirma_senha" name="confirma_senha" class="form-control text-center mb-3" placeholder="Confirme sua senha" required autofocus>

                    <button class="btn btn-lg btn-primary" id="registrar">Registrar</button>
                    <div id="resultAjax" class="text-center mt-5 mb-3 text-primary"></div>

                    <div class="mt-5 text-center text-white">
                        <a href="index.php" class="mt-3 font-weight-bolder btn btn-danger">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // document.getElementById('nome_usuario').value = '13';
            // document.getElementById('senha').value = '123';

            $('#registrar').off('click').on('click', function() {
                let _this = $(this);
                let textButton = _this.text();
                let nome = $('#nome').val();
                let nome_usuario = $('#nome_usuario').val();
                let senha = $('#senha').val();
                let confirma_senha = $('#confirma_senha').val();



                $('#resultAjax').html('');

                _this.text('Aguarde');
                _this.attr('disabled', 'disabled');

                $('#resultAjax').load('./ajax/ajax_registro.php', {
                    nome: nome,
                    nome_usuario: nome_usuario,
                    senha: senha,
                    confirma_senha: confirma_senha
                }, function(retorno) {
                    _this.removeAttr('disabled');
                    _this.text(textButton);

                    if (retorno == '1') {
                        document.getElementById('resultAjax').innerHTML = 'Registro realizado com sucesso!';
                    } else if (retorno == '2') {
                        document.getElementById('resultAjax').innerHTML = 'Por favor complete os campos acima.';
                    } else if (retorno == '3') {
                        document.getElementById('resultAjax').innerHTML = 'As senhas não são iguais.';
                    } else if (retorno == '4') {
                        document.getElementById('resultAjax').innerHTML = 'Este nome já foi cadastrado.';
                    } else if (retorno == '5') {
                        document.getElementById('resultAjax').innerHTML = 'Este nome de usuário já foi cadastrado.';
                    } else {
                        document.getElementById('resultAjax').innerHTML = 'Erro.';
                    }

                });
            });

        });
    </script>

</body>

</html>