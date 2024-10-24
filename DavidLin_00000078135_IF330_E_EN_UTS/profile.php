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
    <title>Profil Pengguna</title>
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

        /* Profile Information Styles */
        .profile-info {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 0 auto;
            max-width: 500px;
        }

        /* Paragraph Styles */
        .profile-info p {
            font-size: 18px;
            line-height: 1.5;
            margin: 10px 0;
        }

        /* Link Styles */
        a {
            display: inline-block;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049; /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>

<div class="profile-info">
    <h1>Profil Pengguna</h1>
    <p>Username: <?= htmlspecialchars($user['username']) ?></p>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <a href="edit_profile.php">Edit Profil</a>
</div>

</body>
</html>
