<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO todos (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $description);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit; // Pastikan untuk keluar setelah header
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
    <title>Buat To-Do</title>
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
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        /* Heading Styles */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50; /* Warna hijau */
        }

        /* Form Container Styles */
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 0 auto;
            max-width: 400px;
        }

        /* Input Styles */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049; /* Warna hijau lebih gelap saat hover */
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
    <h1>Buat To-Do</h1>
    <form method="post">
        Judul: <input type="text" name="title" required><br>
        Deskripsi: <textarea name="description" required></textarea><br>
        <button type="submit">Buat To-Do</button>
    </form>
</div>

</body>
</html>
