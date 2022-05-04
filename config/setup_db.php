<?php
    function setupDatabase($conn, $dbname) {
        createDatabase($conn, $dbname);
        useDatabase($conn, $dbname);
        createUserTable($conn);
        createItemTable($conn);
    }

    function createDatabase($conn, $dbname) {
        $sql = "CREATE DATABASE $dbname";

        if (mysqli_query($conn, $sql)) {
            echo "<br>Table created successfully";
        } else {
            echo "<br>Error creating database: " . mysqli_error($conn);
        }
    }

    function useDatabase($conn, $dbname) {
        $sql = "USE $dbname";

        if (mysqli_query($conn, $sql)) {
            echo "<br>Database selected successfully";
        } else {
            echo "<br>Error selecting database: " . mysqli_error($conn);
        }
    }

    function createUserTable($conn) {
        $sql = "CREATE TABLE user (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,username VARCHAR(30) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL)";

        if (mysqli_query($conn, $sql)) {
            echo "<br>Table created successfully";
        } else {
            echo "<br>Error creating table: " . mysqli_error($conn);
        }
    }


    function createItemTable($conn) {
        $sql = "CREATE TABLE item (
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    name VARCHAR(250) NOT NULL,
                    quantity INT NOT NULL,
                    user_id INT NOT NULL, 
                    CONSTRAINT FK_ItemUser FOREIGN KEY (user_id) REFERENCES user(id))";

        if (mysqli_query($conn, $sql)) {
            echo "<br>Table created successfully";
        } else {
            echo "<br>Error creating table: " . mysqli_error($conn);
        }
    }