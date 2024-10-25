<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

// Ambil filter dan pencarian dari POST
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'all';
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Query dasar
$query = "SELECT * FROM todos WHERE user_id = ?";

// Tambahkan kondisi filter
if ($filter == 'completed') {
    $query .= " AND completed = 1";
} elseif ($filter == 'incomplete') {
    $query .= " AND completed = 0";
}

// Tambahkan kondisi pencarian
if (!empty($search)) {
    $query .= " AND title LIKE ?";
    $search_param = "%" . $search . "%";
}

// Eksekusi query
$stmt = $conn->prepare($query);
if (!empty($search)) {
    $stmt->bind_param("is", $user_id, $search_param);
} else {
    $stmt->bind_param("i", $user_id);
}
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #a1c4fd, #c2e9fb); /* Match with the theme of the uploaded image */
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container-dashboard {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }

        .dashboard-header a {
            text-decoration: none;
            background-color: #0066ff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .todo-list-section h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .todo-list {
            list-style-type: none;
            padding: 0;
        }

        .todo-list li {
            background: #f1f4f9;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            position: relative;
        }

        .todo-list h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .todo-list p {
            margin: 5px 0;
            font-size: 0.95rem;
            color: #555;
        }

        .completed h3 {
            text-decoration: line-through;
            color: #aaa;
        }

        .todo-list-actions {
            position: absolute;
            right: 10px;
            top: 10px;
        }

        .todo-list-actions a {
            text-decoration: none;
            margin-left: 10px;
            color: #0066ff;
        }

        .filter-section {
            margin-top: 20px;
        }

        .filter-section form {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .filter-section input, 
        .filter-section select, 
        .filter-section button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-section button {
            background-color: #0066ff;
            color: white;
            cursor: pointer;
        }

        .profile-link {
            margin-top: 20px;
            text-align: center;
        }

        .profile-link a {
            margin: 0 10px;
            color: #0066ff;
            text-decoration: none;
        }

        .profile-link a:hover {
            text-decoration: underline;
        }
    </style>
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
                    <h3><?= htmlspecialchars($todo['title']) ?></h3>
                    <p><?= htmlspecialchars($todo['description']) ?></p> <!-- Show description below the title -->
                    <div class="todo-list-actions">
                        <?php if (!$todo['completed']): ?>
                            <a href="mark_done.php?id=<?= $todo['id'] ?>" class="done">Mark as Done</a>
                        <?php endif; ?>
                        <a href="edit_todo.php?id=<?= $todo['id'] ?>" class="edit">Edit</a>
                        <a href="delete_todo.php?id=<?= $todo['id'] ?>" class="delete">Hapus</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="filter-section">
        <form method="post" action="dashboard.php">
            <input type="text" name="search" placeholder="Cari tugas..." value="<?= htmlspecialchars($search) ?>" />
            <select name="filter">
                <option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>Semua</option>
                <option value="completed" <?= $filter == 'completed' ? 'selected' : '' ?>>Selesai</option>
                <option value="incomplete" <?= $filter == 'incomplete' ? 'selected' : '' ?>>Belum Selesai</option>
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
