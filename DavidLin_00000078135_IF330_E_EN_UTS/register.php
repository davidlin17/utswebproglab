<?php
include('db.php');

$error_message = ''; // Variabel untuk pesan kesalahan atau keberhasilan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        $error_message = "Registrasi berhasil!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Todolist</title>
    
    <!-- CSS langsung di dalam file -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            background-image: url('blueabstrak.jpg'); /* Ganti dengan gambar yang Anda inginkan */
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            position: relative;
            gap: 20px; /* Tambahkan jarak antara panel kiri dan kanan */
        }

        .left-panel, .right-panel {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 20px; /* Tambahkan padding untuk jarak lebih */
        }

        .left-panel {
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

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        button {
            padding: 12px 15px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #0056b3;
        }

        /* Pesan Kesalahan atau Keberhasilan */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        /* Garis pembatas diagonal */
        .divider {
            position: absolute;
            width: 2px;
            height: 100%;
            background-color: #ccc;
            left: 50%;
            top: 0;
            transform: rotate(30deg);
            z-index: 1;
        }

        /* Panel kanan dengan teks "Welcome to Todolist" */
        .welcome-text {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            text-align: center;
            z-index: 2;
            padding: 20px; /* Tambahkan padding di panel kanan */
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Divider garis diagonal -->
    <div class="divider"></div>

    <!-- Panel Kiri: Form Registrasi -->
    <div class="left-panel">
        <div class="form-wrapper">
            <h2>Registrasi Akun</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit">Daftar</button>
            </form>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

            <!-- Tampilkan pesan kesalahan atau keberhasilan jika ada -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Panel Kanan: Welcome Text -->
    <div class="right-panel">
        <div class="welcome-text">Welcome to "todolist"</div>
    </div>
</div>

</body>
</html>
