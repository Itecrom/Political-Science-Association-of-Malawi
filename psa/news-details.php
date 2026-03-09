<?php
ob_start();
session_start();
include 'includes/db.php';
include 'includes/header.php';


// Debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate slug
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    die("No news article specified.");
}

$slug = $_GET['slug'];

// Fetch the news article
$stmt = $conn->prepare("SELECT * FROM news WHERE slug = ? AND status = 'published' LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("News article not found.");
}
$row = $result->fetch_assoc();

// Handle comment submission BEFORE output and header includes
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_submit'])) {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $comment = trim($_POST['comment']);

    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($comment)) $errors[] = "Comment cannot be empty.";

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO comments (news_id, name, email, comment, approved) VALUES (?, ?, ?, ?, 0)");
            $stmt->bind_param("isss", $row['id'], $name, $email, $comment);
            $stmt->execute();

            // Send email notification to admin
            $to = "leonardjmhone@gmail.com";  // Replace with your admin email
            $subject = "New Comment Submitted on News Article: " . $row['title'];
            $message = "A new comment has been submitted.\n\n";
            $message .= "Name: $name\n";
            $message .= "Email: $email\n";
            $message .= "Comment:\n$comment\n\n";
            $message .= "View article: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

            $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
            $headers .= "Reply-To: $email\r\n";

            mail($to, $subject, $message, $headers);

            $_SESSION['comment_success'] = "✅ Comment submitted successfully and is awaiting approval.";
            header("Location: " . strtok($_SERVER['REQUEST_URI'], '?') . "?slug=" . urlencode($slug) . "#comments");
            exit();
        } catch (Exception $e) {
            $errors[] = "Failed to submit comment: " . $e->getMessage();
        }
    }
}


$title   = htmlspecialchars($row['title']);
$author  = !empty($row['author']) ? htmlspecialchars($row['author']) : 'Admin';
$tags    = $row['tags'];
$content = $row['content'];
$date    = date('d M Y', strtotime($row['date_posted'] ?? $row['created_at']));

// Image
$imagePath = 'images/events/blogsingle.jpg';
if (!empty($row['image'])) {
    $dateFolder = date('Y/m', strtotime($row['date_posted'] ?? $row['created_at']));
    $filepath = "uploads/news/$dateFolder/" . $row['image'];
    if (file_exists($filepath)) {
        $imagePath = $filepath;
    }
}
$image = htmlspecialchars($imagePath);
$fullUrl = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$fullImageUrl = "https://{$_SERVER['HTTP_HOST']}/" . $image;

// Fetch approved comments with pagination
$comments_per_page = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $comments_per_page;

$total_comments_result = $conn->query("SELECT COUNT(*) AS total FROM comments WHERE news_id = {$row['id']} AND approved = 1");
$total_comments = $total_comments_result->fetch_assoc()['total'];
$total_pages = ceil($total_comments / $comments_per_page);

$stmt_comments = $conn->prepare("SELECT * FROM comments WHERE news_id = ? AND approved = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt_comments->bind_param("iii", $row['id'], $comments_per_page, $offset);
$stmt_comments->execute();
$comments = $stmt_comments->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $title ?> - PSA Malawi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars(substr(strip_tags($content), 0, 150)) ?>" />
  <meta property="og:title" content="<?= $title ?>" />
  <meta property="og:description" content="<?= htmlspecialchars(substr(strip_tags($content), 0, 150)) ?>" />
  <meta property="og:image" content="<?= $fullImageUrl ?>" />
  <meta property="og:url" content="<?= $fullUrl ?>" />
  <meta name="author" content="<?= $author ?>" />
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>

<!-- Title Banner -->
<section class="page-title overlay" style="background-image: url(images/background/page-title-2.jpg);">
  <div class="container text-center">
    <h2 class="text-white font-weight-bold"><?= $title ?></h2>
    <h4 class="text-white">Tags: <?= htmlspecialchars($tags) ?></h4>
  </div>
</section>

<!-- Article + Comments -->
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 py-100">
        <article class="bg-white border rounded">
          <img src="<?= $image ?>" alt="<?= $title ?>" class="img-fluid w-100 rounded-top" />
          <div class="p-4">
            <ul class="list-inline mb-3 border-bottom pb-3">
              <li class="list-inline-item">Posted by <strong><?= $author ?></strong></li>
              <li class="list-inline-item">On <?= $date ?></li>
            </ul>
            <div class="mb-4"><?= $content ?></div>

            <div class="mb-4">
              <strong>Share:</strong>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($fullUrl) ?>" target="_blank">Facebook</a> |
              <a href="https://api.whatsapp.com/send?text=<?= urlencode($title . ' - ' . $fullUrl) ?>" target="_blank">WhatsApp</a>
            </div>

            <!-- Comment success -->
            <?php if (isset($_SESSION['comment_success'])): ?>
              <div class="alert alert-success"><?= $_SESSION['comment_success'] ?></div>
              <?php unset($_SESSION['comment_success']); ?>
            <?php endif; ?>

            <!-- Validation errors -->
            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
              </div>
            <?php endif; ?>

            <!-- Approved Comments -->
            <section id="comments" class="mt-5">
              <h4>Comments (<?= $total_comments ?>)</h4>
              <?php if ($comments->num_rows > 0): ?>
                <?php while ($c = $comments->fetch_assoc()): ?>
                  <div class="border-bottom mb-3 pb-2">
                    <strong><?= htmlspecialchars($c['name']) ?></strong>
                    <small class="text-muted">on <?= date('d M Y', strtotime($c['created_at'])) ?></small><br />
                    <div><?= nl2br(htmlspecialchars($c['comment'])) ?></div>
                  </div>
                <?php endwhile; ?>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                  <ul class="pagination mt-3">
                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                      <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?slug=<?= urlencode($slug) ?>&page=<?= $p ?>#comments"><?= $p ?></a>
                      </li>
                    <?php endfor; ?>
                  </ul>
                <?php endif; ?>
              <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
              <?php endif; ?>
            </section>

            <!-- Comment Form -->
            <section class="mt-5">
              <h4>Leave a Comment</h4>
              <form method="post">
                <input type="text" name="name" class="form-control mb-2" placeholder="Your Name" required />
                <input type="email" name="email" class="form-control mb-2" placeholder="Your Email" required />
                <textarea name="comment" class="form-control mb-2" placeholder="Your Comment" rows="4" required></textarea>
                <button type="submit" name="comment_submit" class="btn btn-primary">Submit</button>
              </form>
            </section>
          </div>
        </article>
      </div>

      <!-- Sidebar -->
      <aside class="col-lg-4 py-100">
        <div class="bg-white sidebar-box-shadow px-4 py-4">
          <div class="mb-4">
            <h4>Search</h4>
            <form method="get" action="news.php">
              <input type="text" name="search" class="form-control" placeholder="Search..." />
            </form>
          </div>

          <div class="mb-4">
            <h4>Related News</h4>
            <ul class="list-unstyled">
              <?php
              $stmtRelated = $conn->prepare("SELECT title, slug FROM news WHERE id != ? ORDER BY RAND() LIMIT 3");
              $stmtRelated->bind_param("i", $row['id']);
              $stmtRelated->execute();
              $related = $stmtRelated->get_result();
              while ($r = $related->fetch_assoc()) {
                echo '<li><a href="news-details.php?slug=' . htmlspecialchars($r['slug']) . '">' . htmlspecialchars($r['title']) . '</a></li>';
              }
              ?>
            </ul>
          </div>

          <div class="mb-4">
            <h4>Tags</h4>
            <ul class="list-inline">
              <?php
              $tagsArr = array_filter(array_map('trim', explode(',', $tags)));
              foreach ($tagsArr as $tag) {
                echo '<li class="list-inline-item"><a href="news.php?search=' . urlencode($tag) . '">' . htmlspecialchars($tag) . '</a></li>';
              }
              ?>
            </ul>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Scripts -->
<script src="plugins/jQuery/jquery.min.js"></script>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="js/script.js"></script>


<?php ob_end_flush(); ?>

</body>
</html>
