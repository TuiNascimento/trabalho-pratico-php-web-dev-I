<?php
    require('../config/db_connect.php');
    require('../src/authenticate.php');

    $conn = connect();
    $login_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["username"]) || empty($_POST["password"])) {
            echo "Dados inválidos. É necessário preencher todos os campos.";
        } else {
            if (authenticate($conn, $_POST["username"], $_POST["password"])) {
                header("Location: home.php");
                mysqli_close($conn);
                exit();
            } else {
                echo "Não foi encontrado nenhum cadastro com as credenciais informadas. Tente novamente.";
            };
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../resources/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="containerTitulo">
        <h1 class="titulo">iList</h1>
    </div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="containerInterface" id="row">
            <div class="column">
                <div class="container" onmousemove="focusInputLogin()">
                    <br>
                    <label for="usuario" >Usuário:</label> <br>
                    <p id="avisoUsuario" class="aviso"></p>
                    <i class="fa fa-user"></i>
                    <input type="text" class="input" name="username" id="usuario" placeholder="Username">
                </div>
            </div>
            <div class="column">
                <div class="container" onmousemove="focusInputPassword()">
                    <br>
                    <label for="senha">Senha:</label><br>
                    <p class="aviso" id="avisoSenha"></p>
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="senha" placeholder="*******">
                </div>
            </div>
            <div class="buttonsContainer">
                <div class="containerButtonLogin">
                    <button type="submit" class="buttonLogin" id="buttonLogin">Entrar</button>
                </div>
                <div class="containerButtonCancel">
                    <a href="create_account.php"><button type="button" class="buttonCancel">Nova conta</button></a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
