<?php
    function authenticate($conn, $username, $password) {
        $username = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT id, password FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $sql) or die("Error: ".mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            echo print_r($user);
            if (password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user_id"] = $user["id"];
                return true;
            };
        }

        return false;
    }