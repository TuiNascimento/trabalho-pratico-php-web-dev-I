<?php

    function addItem($conn, $item_name, $item_quantity, $user_id) {
        $sql = "INSERT INTO item (name, quantity, user_id) VALUES ('$item_name', $item_quantity, $user_id)";
        if (!mysqli_query($conn, $sql)) {
            die("Error: " . $sql . "<br>" . mysqli_error($conn));
            return errorAlert("Falha ao adicionar o item [$item_name].");
        }

        return successAlert("Item adicionado com sucesso.");
    }

    function updateItem($conn, $item_id, $item_name, $item_quantity, $user_id) {
        $sql = "UPDATE item set name = '$item_name', quantity = $item_quantity WHERE id = $item_id AND user_id = $user_id";

        if (!mysqli_query($conn, $sql)) {
            die("Error: " . $sql . "<br>" . mysqli_error($conn));
            return errorAlert("Falha ao editar o item $item_id.");
        }
        return successAlert("Item editado com sucesso.");
    }

    function deleteItem($conn, $item_id, $user_id) {
        $sql = "DELETE FROM item WHERE id = $item_id AND user_id = $user_id";

        if (!mysqli_query($conn, $sql)) {
            die("Error: " . $sql . "<br>" . mysqli_error($conn));
            return errorAlert("Erro ao deletar o item $item_id.");
        }

        return successAlert("Item removido com sucesso.");
    }
