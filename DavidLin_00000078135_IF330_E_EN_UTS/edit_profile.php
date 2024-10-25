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
    <title>Edit Profil - Todolist</title>
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
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            background-image: url('blueabstrak.jpg'); 
        }

        /* Container Styles */
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        /* Animasi Fade In */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Heading Styles */
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            position: relative;
        }

        h1::after {
            content: "";
            width: 80px;
            height: 3px;
            background-color: #007bff;
            display: block;
            margin: 10px auto 0 auto;
        }

        /* Input Styles */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Warna tombol biru */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3; /* Biru lebih gelap saat hover */
        }

        /* Link Styles */
        a {
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            margin-top: 10px;
            width: 100%;
        }

        a:hover {
            background-color: #0056b3;
        }

        /* Button animation */
        a:active, button:active {
            transform: scale(0.98);
        }

        /* Message Styles */
        p {
            text-align: center;
            margin-top: 10px;
        }

        /* Divider line for better separation */
        .divider-horizontal {
            width: 100%;
            height: 2px;
            background-color: #007bff;
            margin: 30px 0;
        }

        /* Keterangan untuk kolom */
        .form-info {
            font-size: 12px;
            color: #555;
            margin-bottom: 10px;
            margin-top: -8px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit Profil</h1>

    <form method="post">
        Username: <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required placeholder="Username"><br>
        <p class="form-info">Harap isi username yang baru atau tetap gunakan username lama</p>

        Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Email"><br>
        <p class="form-info">Harap isi email yang baru atau tetap gunakan email lama</p>

        Password: <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"><br>
        <p class="form-info">Kosongkan jika tidak diubah</p>

        <button type="submit">Perbarui Profil</button>
    </form>

    <div class="divider-horizontal"></div> <!-- Garis horizontal -->

    <!-- Tombol Kembali ke Dashboard -->
    <a href="dashboard.php">Kembali ke Dashboard</a>
</div>

</body>
</html>

