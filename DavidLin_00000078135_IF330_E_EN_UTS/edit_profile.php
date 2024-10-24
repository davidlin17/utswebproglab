<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $password, $user_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Profil berhasil diperbarui!</p>";
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
    <title>Edit Profil</title>
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
        input[type="email"],
        input[type="password"] {
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
    <h1>Edit Profil</h1>
    <form method="post">
        Username: <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
        Password: <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"><br>
        <button type="submit">Perbarui Profil</button>
    </form>
</div>

</body>
</html>
