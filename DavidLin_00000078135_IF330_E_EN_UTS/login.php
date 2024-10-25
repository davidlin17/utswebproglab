<?php
include('db.php');
session_start();

$error_message = ''; // Variabel untuk pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        } else {
            $error_message = "Informasi Salah"; // Password salah
        }
    } else {
        $error_message = "Informasi Salah"; // User tidak ditemukan
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Todolist</title>
    
    <!-- CSS langsung di dalam file -->
    <style>
        /* Reset CSS */
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
        }

        .left-panel, .right-panel {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
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

        /* Animasi Fade Out */
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-30px);
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
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

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

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        /* Floating label */
        label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #007bff;
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

        /* Pesan Error */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        /* Garis pembatas diagonal */
        .divider {
            position: absolute;
            width: 3px;
            height: 100%;
            background-color: #ccc;
            left: 50%;
            top: 0;
            transform: rotate(30deg);
            z-index: 1;
        }

        /* Panel kanan dengan teks "Welcome to Todolist" */
        .welcome-text {
            font-size: 64px;
            font-weight: bold;
            color: #333;
            text-align: center;
            z-index: 2;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Divider garis diagonal -->
    <div class="divider"></div>

    <!-- Panel Kiri: Form Login -->
    <div class="left-panel">
        <div class="form-wrapper">
            <h2>Login</h2>
            <form method="post">
                <div class="form-group">
                    <input type="email" name="email" placeholder=" " required>
                    <label for="email">Email</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder=" " required>
                    <label for="password">Password</label>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

            <!-- Tampilkan pesan kesalahan jika ada -->
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
