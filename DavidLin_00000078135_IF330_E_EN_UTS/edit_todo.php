<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $todo_id = (int)$_GET['id'];

    // Ambil data To-Do yang ingin diedit
    $stmt = $conn->prepare("SELECT title, description FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $todo_id, $user_id);
    $stmt->execute();
    $todo = $stmt->get_result()->fetch_assoc();

    if (!$todo) {
        echo "To-Do tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    // Update To-Do di database
    $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $description, $todo_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styles */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #dfefff, #b0d5fa); /* Gradien biru muda */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Form Container Styles */
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        /* Heading Styles */
        h1 {
            margin-bottom: 20px;
            color: #333; /* Warna teks judul */
            font-size: 24px;
        }

        /* Input Styles */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Warna biru senada */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3; /* Warna biru lebih gelap saat hover */
        }

        /* Message Styles */
        p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit To-Do</h1>
    <form method="post">
        Judul: <input type="text" name="title" value="<?= htmlspecialchars($todo['title']) ?>" required><br>
        Deskripsi: <textarea name="description" required><?= htmlspecialchars($todo['description']) ?></textarea><br>
        <button type="submit">Perbarui To-Do</button>
    </form>
</div>

</body>
</html>
