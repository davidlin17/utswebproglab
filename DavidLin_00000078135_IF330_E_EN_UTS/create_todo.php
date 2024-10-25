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
            font-family: Arial, sans-serif;
        }

        /* Body Styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #c9e3ff, #f2f7ff);
            transition: opacity 0.5s ease-in-out;
        }

        /* Form Container Styles */
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            max-width: 90%;
            text-align: center;
        }

        /* Heading Styles */
        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        /* Input Styles */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Warna biru */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3; /* Warna biru lebih gelap saat hover */
        }

        /* Back Button Styles */
        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d; /* Warna abu-abu */
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .back-button a:hover {
            background-color: #5a6268; /* Warna abu-abu lebih gelap saat hover */
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Buat To-Do</h1>
    <form method="post">
        <label for="title">Judul:</label>
        <input type="text" id="title" name="title" required>
        <label for="description">Deskripsi:</label>
        <textarea id="description" name="description" rows="5" required></textarea>
        <button type="submit">Buat To-Do</button>
    </form>
    <div class="back-button">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
