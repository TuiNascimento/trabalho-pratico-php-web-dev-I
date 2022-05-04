<?php
    session_start();
    require('../config/db_connect.php');
    require('../src/item_service.php');
    require('../src/alert.php');

    $conn = connect();

	$item_name = $item_quantity = "";

    function validaCampos() {
        $success = true;
        $fields = ["item_name", "item_quantity"];
        foreach($fields as $field) {
            if(empty($_POST[$field])) {
                $success = false;
            }
        }

        return $success;
    }

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];
        if ($action == "ADD_ITEM" || $action == "EDIT_ITEM") {
            if (validaCampos()) {
                $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
                $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
                $user_id = $_SESSION["user_id"];

                if ($action == "ADD_ITEM") {
                    $msg = addItem($conn, $item_name, $item_quantity, $user_id);
                } else if ($action == "EDIT_ITEM") {
                    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
                    $msg = updateItem($conn, $item_id, $item_name, $item_quantity, $user_id);
                }
            } else {
                $msg = errorAlert("Todos os campos precisam ser preenchidos.");
            }
        } else if ($action == "DELETE_ITEM") {
            $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
            $user_id = $_SESSION["user_id"];

            $msg = deleteItem($conn, $item_id, $user_id);
        } else if ($action == "LOGOUT") {
            session_destroy();
            header("Location: login.php");
            exit();
        }
	}

    $user_id = $_SESSION["user_id"];
	$sql = "SELECT * FROM item where user_id = '$user_id'";
	$list = mysqli_query($conn, $sql);

	if (!$list) {
		die("Error: " . $sql . "<br>" . mysqli_error($conn));
	}

	mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="br">
	<head>
		<meta charset="utf-8">
		<title>iList</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../resources/css/home.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../resources/js/home.js"></script>
	</head>
	<body>
        <div class="logout-button">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="action" value="LOGOUT">
                <button class="btn btn-secondary"><i class="fa fa-sign-out"></i> | Logout</button>
            </form>
        </div>
		<div class="list">
			<h2 class="title">iList</h2>

			<?php if (!empty($msg)): ?>
				<?= $msg ?>
			<?php endif; ?>

			<?php if (mysqli_num_rows($list) > 0): ?>
				<?php while($item = mysqli_fetch_assoc($list)): ?>
					<div class="item rounded">
                        <input type="hidden" class="js-item-name" value="<?= $item['name'] ?>"/>
                        <input type="hidden" class="js-item-quantity" value="<?= $item['quantity'] ?>"/>
                        <input type="hidden" class="js-item-id" value="<?= $item['id'] ?>"/>

                        <div class="item-title">
                            <h4><?= $item['name'] ?></h4>
                        </div>
                        <div class="item-quantity">
                            <p>Quantidade: <?= $item['quantity'] ?></p>
                        </div>
                        <div class="delete-button">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="action" value="DELETE_ITEM">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

                                <button class="btn btn-danger"><i class="fa fa-times"></i> | Remover</button>
                            </form>
                        </div>
                        <div class="edit-button">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="action" value="EDIT_ITEM">
                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

                                <button class="btn btn-info js-edit-button"><i class="fa fa-edit"></i> | Editar</button>
                            </form>
                        </div>
					</div>
                    <br>
				<?php endWhile; ?>
			<?php endIF; ?>

            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="action" value="ADD_ITEM">
                <div class="item rounded">
                    <div class="item-title">
                        <h4>Item: <input type="text" class="bg-transparent transparent-input" name="item_name" placeholder="Leite"/><br></h4>
                    </div>
                    <div class="item-quantity">
                        <p>Quantidade: <input type="number" class="bg-transparent transparent-input" name="item_quantity" placeholder="3"/></p>
                    </div>
                    <div class="add-button">
                        <button class="btn btn-success"><i class="fa fa-plus"></i> | Adicionar</button>
                    </div>
                </div>
            </form>
		</div>
	</body>
</html>