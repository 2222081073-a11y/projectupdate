<?php
session_start();
include "db.php";

// fetch gallery
$stmt = mysqli_prepare($conn, "SELECT id, caption, image_path, created_at FROM gallery_items ORDER BY id DESC");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>খেয়া শিল্পকলা একাডেমি - Gallery</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; }
table { width:100%; border-collapse: collapse; margin-top: 20px;}
table, th, td { border:1px solid #999; }
th, td { padding:10px; text-align:center; }
.thumb { width:80px; height:80px; object-fit:cover; border-radius:6px; }
a { text-decoration:none; color:blue; }
a:hover { text-decoration:underline; }
</style>
</head>
<body>

<h2>🎨 খেয়া শিল্পকলা একাডেমি - Gallery</h2>

<?php if(!empty($_SESSION['admin_logged_in'])): ?>
    <p style="color:green">Admin Logged In | <a href="logout.php">Logout</a></p>
<?php elseif(!empty($_SESSION['student_logged_in'])): ?>
    <p style="color:blue">Student Logged In | <a href="logout.php">Logout</a></p>
<?php else: ?>
    <p><a href="admin_login.php">Admin Login</a> | <a href="student_login.php">Student Login</a></p>
<?php endif; ?>

<hr>

<!-- Admin only: Add New Image -->
<?php if(!empty($_SESSION['admin_logged_in'])): ?>
<h3>Add New Image</h3>
<form action="insert.php" method="POST" enctype="multipart/form-data">
    Caption: <input type="text" name="caption" required>
    Image: <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>
<?php endif; ?>

<hr>

<h3>Gallery Items</h3>
<table>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Caption</th>
    <th>Created</th>
    <?php if(!empty($_SESSION['admin_logged_in'])): ?>
    <th>Action</th>
    <?php endif; ?>
</tr>

<?php foreach($items as $row): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><img src="uploads/<?= $row['image_path'] ?>" class="thumb"></td>
    <td><?= $row['caption'] ?></td>
    <td><?= $row['created_at'] ?></td>
    <?php if(!empty($_SESSION['admin_logged_in'])): ?>
    <td>
        <a href="update.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
    </td>
    <?php endif; ?>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
