<?php
    require('../config/db_connect.php');

    $conn = connect();
    $login_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $login_err = "Dados inválidos. É necessário preencher todos os campos.";
        } else {
            $login_err = createAccount($conn, $_POST["username"], $_POST["password"]);
        }

        if (!$login_err) {
            header("Location: login.php");
            mysqli_close($conn);
            exit();
        }

        echo "<script>alert('$login_err')</script>";
        mysqli_close($conn);
    }

    function isUsernameAvailable($conn, $username) {
        $username = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return false;
        }

        return true;
    }

    function createAccount($conn, $param_username, $password) {
        if (empty($param_username) || empty($password)) {
            return "É necessário preencher todos os campos.";
        }

        $param_username = mysqli_real_escape_string($conn, $param_username);
        if (!isUsernameAvailable($conn, $param_username)) {
           return "Já existe usuário com este nome.";
        };

        $password = mysqli_real_escape_string($conn, $password);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (username, password) VALUES ('$param_username', '$hashed_password')";

        mysqli_query($conn, $sql) or die("Error: ".mysqli_error($conn));

        return "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="../resources/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="containerTitulo">
        <h1 class="titulo">Crie sua conta</h1>
    </div>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="containerInterface" id="row">
            <div class="column">
                <div class="container" onmousemove="focusInputLogin()">
                    <br>
                    <label for="usuario" >Nome de usuário:</label> <br>
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
                    <input type="password" id="senha" name="password" placeholder="*******">
                </div>
            </div>
            <div class="buttonsContainer">
                <div class="containerButtonLogin">
                    <button type="submit" class="buttonLogin" id="buttonLogin">Criar conta</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>