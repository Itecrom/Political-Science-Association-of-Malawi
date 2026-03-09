<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: auth/login.php");

include 'includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM comments WHERE id = $id");
}

header("Location: manage_comments.php");
exit;
?>
