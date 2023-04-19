<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: home.php");
}
?>

<!doctype html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="asdf">
    <meta name="author" content="André">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cb8454615f.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="css/index.css" rel="stylesheet">
</head>


<body class="bg-dark">
    <div class="mt-5 container">
        <div class="row justify-content-center text-center">
            <div class="mt-8">
                <div class="form-signin">
                    <span style="color: Tomato;">
                        <i class="mb-4 mt-5 fa-solid fa-circle-user fa-6x"></i>
                    </span>
                    <h3 class="mb-3 font-weight-normal text-white">Login</h3>
                    <input type="nome_usuario" id="nome_usuario" name="nome_usuario" class="form-control text-center mb-2" placeholder="Digite seu nome de usuário" required autofocus>
                    <input type="password" id="senha" name="senha" class="form-control text-center mb-2" placeholder="Digite sua senha" required>
                    <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Logar</button>
                    <div id="resultAjax" class="text-center mt-5 mb-3 text-primary"></div>
                    <button class="btn btn-lg btn-primary btn-block" id="registrar">Registrar</button>

                    <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#login').off('click').on('click', function() {
                let _this = $(this);
                let textButton = _this.text();
                let nome_usuario = $('#nome_usuario').val();
                let senha = $('#senha').val();

                $('#resultAjax').html('');

                _this.text('Aguarde');
                _this.attr('disabled', 'disabled');

                $('#resultAjax').load('./ajax/ajax_login.php', {
                    nome_usuario: nome_usuario,
                    senha: senha
                }, function(retorno) {
                    _this.removeAttr('disabled');
                    _this.text(textButton);

                    if (retorno == '1') {
                        window.location = "home.php";
                    } else if (retorno == '-1') {
                        document.getElementById('resultAjax').innerHTML = 'Nome de usuario e/ou senha incorretos!';
                    } else if (retorno == '2') {
                        document.getElementById('resultAjax').innerHTML = 'Por favor complete os campos acima.';
                    } else {
                        document.getElementById('resultAjax').innerHTML = 'Erro.';
                    }

                });
            });
            $('#registrar').off('click').on('click', function() {
                window.location = "registrar.php";
            });
        });
    </script>

</body>

</html>