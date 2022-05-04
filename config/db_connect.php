<?php
    function connect() {
        // Create connection
        $conn = mysqli_connect("127.0.0.1",
            "fusion",
            "neo@123");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Choose database
        $sql = "USE trabalho";
        if (!mysqli_query($conn, $sql)) {
            require_once('setup_db.php');
            setupDatabase($conn, "trabalho");
            if(!mysqli_query($conn, $sql)) {
                echo "Erro na configuração do banco de dados!";
                exit(500);
            }
        }

        return $conn;
    }
?>
