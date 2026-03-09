<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: auth/login.php");
include 'includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Missing news ID.");

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) die("News not found.");

// Slug generator
function generateSlug($string) {
  return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

// Ensure unique slug
function generateUniqueSlug($conn, $title, $currentId) {
  $baseSlug = generateSlug($title);
  $slug = $baseSlug;
  $i = 1;

  while (true) {
    $check = $conn->prepare("SELECT id FROM news WHERE slug = ? AND id != ?");
    $check->bind_param("si", $slug, $currentId);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) break;
    $slug = $baseSlug . '-' . $i++;
  }

  return $slug;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $author = $_POST['author'];
  $content = $_POST['content'];
  $category = $_POST['category'];
  $tags = $_POST['tags'];
  $date = $_POST['date'];

  $slug = generateUniqueSlug($conn, $title, $id);

  $stmt = $conn->prepare("UPDATE news SET title=?, slug=?, author=?, content=?, category=?, tags=?, date_posted=? WHERE id=?");
  $stmt->bind_param("sssssssi", $title, $slug, $author, $content, $category, $tags, $date, $id);
  $stmt->execute();

  header("Location: manage_news.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit News - PSA Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
 
  <style>
    .cke {
      max-width: 100%;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-black text-white flex flex-col px-4 py-6">
    <div class="text-center mb-8">
      <img src="images/logo.png" alt="PSA Logo" class="mx-auto mb-3 w-16">
      <h2 class="text-xl font-semibold">PSA Admin</h2>
    </div>
    <nav class="flex flex-col gap-3 text-sm">
      <a href="dashboard.php" class="hover:bg-green-700 py-2 px-3 rounded transition">Dashboard</a>
      <a href="manage_news.php" class="hover:bg-green-700 py-2 px-3 rounded transition">Manage News</a>
      <a href="add_news.php" class="hover:bg-green-700 py-2 px-3 rounded transition">Add News</a>
      <a href="auth/logout.php" class="mt-4 bg-red-600 py-2 px-3 text-center rounded hover:bg-red-700 transition">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <h1 class="text-2xl font-bold text-green-700 mb-6">✏️ Edit News Article</h1>

    <form method="POST" class="bg-white shadow rounded p-6 space-y-5">
      <label class="block">
        <span class="font-medium text-gray-700">Title</span>
        <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required class="w-full px-4 py-2 border rounded">
      </label>

      <label class="block">
        <span class="font-medium text-gray-700">Author</span>
        <input type="text" name="author" value="<?= htmlspecialchars($news['author']) ?>" required class="w-full px-4 py-2 border rounded">
      </label>

      <label class="block">
        <span class="font-medium text-gray-700">Category</span>
        <input type="text" name="category" value="<?= htmlspecialchars($news['category']) ?>" class="w-full px-4 py-2 border rounded">
      </label>

      <label class="block">
        <span class="font-medium text-gray-700">Tags</span>
        <input type="text" name="tags" value="<?= htmlspecialchars($news['tags']) ?>" class="w-full px-4 py-2 border rounded">
      </label>

      <label class="block">
        <span class="font-medium text-gray-700">Date Posted</span>
        <input type="date" name="date" value="<?= htmlspecialchars($news['date_posted']) ?>" class="w-full px-4 py-2 border rounded">
      </label>

      <label class="block">
        <span class="font-medium text-gray-700">Content</span>
        <textarea name="content" id="editor" rows="15"><?= htmlspecialchars($news['content']) ?></textarea>
      </label>

      <div class="flex justify-between items-center">
        <a href="manage_news.php" class="text-red-600 hover:underline text-sm">← Cancel</a>
        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded shadow">
          <i class="fas fa-save mr-1"></i> Save Changes
        </button>
      </div>
    </form>

    <footer class="text-center text-sm text-gray-500 mt-10">
      &copy; <?= date('Y') ?> PSA Admin Panel — By <b>Leonard Mhone</b>
    </footer>
  </main>
</div>

<script>
CKEDITOR.replace('editor', {
  filebrowserUploadUrl: 'ckeditor_upload.php',
  filebrowserUploadMethod: 'form',
});
</script>

</body>
</html>
