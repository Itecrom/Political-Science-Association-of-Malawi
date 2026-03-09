<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: auth/login.php");
include 'includes/db.php';

$success = '';
$error = '';

// Slug generation
function generateSlug($string) {
  return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

function generateUniqueSlug($conn, $title) {
  $baseSlug = generateSlug($title);
  $slug = $baseSlug;
  $i = 1;

  while (true) {
    $check = $conn->prepare("SELECT id FROM news WHERE slug = ? LIMIT 1");
    $check->bind_param("s", $slug);
    $check->execute();
    $check->store_result();
    if ($check->num_rows === 0) break;
    $slug = $baseSlug . '-' . $i++;
  }

  return $slug;
}

// Resize/compress image
function compressImage($source, $destination, $quality = 75) {
  $info = getimagesize($source);
  switch ($info['mime']) {
    case 'image/jpeg':
      $image = imagecreatefromjpeg($source);
      break;
    case 'image/png':
      $image = imagecreatefrompng($source);
      break;
    case 'image/gif':
      $image = imagecreatefromgif($source);
      break;
    default:
      return false;
  }

  imagejpeg($image, $destination, $quality);
  imagedestroy($image);
  return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $author = $_SESSION['admin'];
  $content = $_POST['content'];
  $tags = $_POST['tags'];
  $category = $_POST['category'];
  $date = $_POST['date_posted'] ?: date('Y-m-d');
  $featured = isset($_POST['featured']) ? 1 : 0;

  $slug = generateUniqueSlug($conn, $title);
  $image = '';

  if (!empty($_FILES['image']['name'])) {
    $year = date('Y');
    $month = date('m');
    $uploadDir = "uploads/news/{$year}/{$month}/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $newFileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
    $targetPath = $uploadDir . $newFileName;

    if (compressImage($_FILES['image']['tmp_name'], $targetPath, 75)) {
      $image = $targetPath;
    } else {
      $error = "Image upload failed.";
    }
  }

  $stmt = $conn->prepare("INSERT INTO news (title, slug, author, content, image, date_posted, category, tags, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssssi", $title, $slug, $author, $content, $image, $date, $category, $tags, $featured);

  if ($stmt->execute()) {
    $success = "News article added successfully!";
  } else {
    $error = "Failed to add news: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add News - PSA Admin</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    /* Ensure CKEditor container takes full width */
    .cke {
      max-width: 100%;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <div class="w-64 bg-gradient-to-b from-black via-red-700 to-green-800 text-white flex flex-col p-4 shadow-lg">
    <div class="text-2xl font-bold mb-6 text-center">PSA Admin</div>
    <nav class="space-y-2">
      <a href="dashboard.php" class="block px-3 py-2 rounded hover:bg-white hover:text-black"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
      <a href="manage_news.php" class="block px-3 py-2 rounded hover:bg-white hover:text-black"><i class="fas fa-newspaper mr-2"></i>Manage News</a>
      <a href="add_news.php" class="block px-3 py-2 rounded bg-white text-black font-semibold"><i class="fas fa-plus-circle mr-2"></i>Add News</a>
      <a href="auth/logout.php" class="block mt-4 px-3 py-2 rounded bg-red-700 hover:bg-red-800"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="flex-1 p-6">
    <h2 class="text-3xl font-bold text-green-800 mb-4">📰 Add News Article</h2>

    <?php if ($success): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-6">
      <div>
        <label class="block font-semibold mb-1">News Title</label>
        <input type="text" name="title" required class="w-full border p-2 rounded"/>
      </div>

      <div>
        <label class="block font-semibold mb-1">Category</label>
        <input type="text" name="category" required class="w-full border p-2 rounded"/>
      </div>

      <div>
        <label class="block font-semibold mb-1">Tags (comma-separated)</label>
        <input type="text" name="tags" class="w-full border p-2 rounded"/>
      </div>

      <div>
        <label class="block font-semibold mb-1">Upload Featured Image</label>
        <input type="file" name="image" id="imageInput" accept="image/*" class="w-full mb-2"/>
        <img id="preview" class="rounded border w-64 h-auto hidden"/>
      </div>

      <div>
        <label class="block font-semibold mb-1">Date (optional)</label>
        <input type="date" name="date_posted" class="w-full border p-2 rounded" value="<?= date('Y-m-d') ?>"/>
      </div>

      <div>
        <label class="block font-semibold mb-1">Full Article Content</label>
        <textarea name="content" id="editor" rows="15" class="w-full border p-2 rounded"></textarea>
      </div>

      <div>
        <label class="inline-flex items-center">
          <input type="checkbox" name="featured" value="1" class="mr-2"/>
          <span class="font-semibold">Feature this article on homepage slider</span>
        </label>
      </div>

      <div class="text-right">
        <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition">
          <i class="fas fa-check-circle mr-1"></i> Publish Article
        </button>
      </div>
    </form>
  </div>
</div>

<footer class="text-center py-4 mt-6 text-sm text-gray-600 bg-gray-200 border-t">
  &copy; <?= date('Y') ?> PSA Admin Panel v1.0 — By <strong>Leonard Mhone</strong>
</footer>

<script>
  // CKEditor with image upload enabled
CKEDITOR.replace('editor', {
  filebrowserUploadUrl: 'ckeditor_upload.php',
  filebrowserUploadMethod: 'form',
});

  // Preview featured image before upload
  document.getElementById('imageInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
  });
</script>

</body>
</html>
