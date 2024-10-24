<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$todo_id = $_GET['id'];

// Periksa apakah to-do list ini dimiliki oleh user yang sedang login
$query = "SELECT * FROM todos WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $todo_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$todo = $result->fetch_assoc();

if (!$todo) {
    echo "To-Do List tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya!";
    exit();
}

// Hapus to-do list jika konfirmasi diberikan
if (isset($_POST['confirm_delete'])) {
    $delete_query = "DELETE FROM todos WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $todo_id, $_SESSION['user_id']);
    $delete_stmt->execute();

    // Redirect ke dashboard dengan pesan sukses
    header("Location: dashboard.php?message=deleted");
    exit();
} elseif (isset($_POST['cancel_delete'])) {
    // Jika pengguna memilih untuk tidak menghapus, kembali ke dashboard
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus To-Do</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirm-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-cancel {
            background-color: #bdc3c7;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #95a5a6;
        }
    </style>
</head>
<body>

    <div class="confirm-container">
        <h1>Konfirmasi Hapus</h1>
        <p>Apakah Anda yakin ingin menghapus to-do list <strong>"<?= htmlspecialchars($todo['title']) ?>"</strong>?</p>

        <form method="POST">
            <div class="btn-group">
                <button type="submit" name="confirm_delete" class="btn-delete">Hapus</button>
                <button type="submit" name="cancel_delete" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>

</body>
</html>