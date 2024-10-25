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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Todolist</title>
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
            background-image: url('blueabstrak.jpg'); /* Ganti dengan gambar yang Anda inginkan */
        }

        /* Container Styles */
        .profile-container {
            width: 80%;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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

        /* Profile Information Styles */
        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .profile-info p {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
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
            font-size: 16px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #0056b3;
        }

        /* Button animation */
        a:active {
            transform: scale(0.98);
        }

        /* Divider line for better separation */
        .divider-horizontal {
            width: 100%;
            height: 2px;
            background-color: #007bff;
            margin: 30px 0;
        }

        /* Flexbox container for buttons */
        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

    </style>
</head>
<body>

<div class="profile-container">
    <h1>Profil Pengguna</h1>

    <div class="profile-info">
        <p>Username: <?= htmlspecialchars($user['username']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <div class="divider-horizontal"></div> <!-- Garis horizontal -->

    <!-- Tombol Edit dan Kembali -->
    <div class="button-container">
        <a href="edit_profile.php">Edit Profil</a>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
