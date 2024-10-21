<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM todos WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$todos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Menghubungkan ke file CSS -->
</head>
<body>

<div class="container-dashboard">
    <div class="dashboard-header">
        <h1>Dashboard To-Do List</h1>
        <a href="create_todo.php">Buat To-Do Baru</a>
    </div>

    <div class="todo-list-section">
        <h2>Daftar To-Do Anda</h2>
        <ul class="todo-list">
            <?php while($todo = $todos->fetch_assoc()): ?>
                <li class="<?= $todo['completed'] ? 'completed' : '' ?>">
                    <?= htmlspecialchars($todo['title']) ?>
                    <div class="todo-list-actions">
                        <a href="edit_todo.php?id=<?= $todo['id'] ?>" class="edit">Edit</a>
                        <a href="delete_todo.php?id=<?= $todo['id'] ?>" class="delete">Hapus</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="filter-section">
        <form method="post" action="">
            <input type="text" name="search" placeholder="Cari tugas..." />
            <select name="filter">
                <option value="all">Semua</option>
                <option value="completed">Selesai</option>
                <option value="incomplete">Belum Selesai</option>
            </select>
            <button type="submit">Terapkan Filter</button>
        </form>
    </div>

    <div class="profile-link">
        <a href="profile.php">Lihat Profil</a> | <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
