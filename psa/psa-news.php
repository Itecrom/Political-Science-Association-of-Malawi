<?php
include 'includes/db.php';
include 'includes/header.php';

function resolveImagePath($image, $date) {
  $datePath = date('Y/m', strtotime($date));
  $path = "uploads/news/$datePath/" . htmlspecialchars($image);
  return (!empty($image) && file_exists($path)) ? $path : 'images/events/blogsingle.jpg';
}

$limit = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search filter (optional)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_sql = $search ? " AND (title LIKE ? OR content LIKE ? OR tags LIKE ?)" : "";

// Count total
$count_sql = "SELECT COUNT(*) AS total FROM news WHERE status='published' $search_sql";
$stmt_count = $conn->prepare($count_sql);
if ($search) {
    $param = "%$search%";
    $stmt_count->bind_param("sss", $param, $param, $param);
}
$stmt_count->execute();
$total = $stmt_count->get_result()->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Get articles
$news_sql = "SELECT * FROM news WHERE status='published' $search_sql ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($news_sql);
if ($search) {
    $stmt->bind_param("sssii", $param, $param, $param, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>News - PSA Malawi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .sidebar-box-shadow {
      word-wrap: break-word;
      overflow-wrap: break-word;
    }
    .card-text, .text-dark {
      word-break: break-word;
    }
  </style>
</head>
<body>

<section class="page-title overlay" style="background-image: url('images/background/page-title.jpg'); background-size: cover; position: relative;">
  <div style="background-color: rgba(0,0,0,0.6); position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
  <div class="container text-center" style="position:relative; z-index:2;">
    <h2 class="text-white font-weight-bold">News and Events</h2>
  </div>
</section>

<section class="section bg-light">
  <div class="container">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <div class="row">
          <?php while ($row = $result->fetch_assoc()):
            $title = htmlspecialchars($row['title']);
            $slug = urlencode($row['slug']);
            $author = htmlspecialchars($row['author'] ?? 'Admin');
            $date = date('d M Y', strtotime($row['created_at']));
            $tags = htmlspecialchars($row['tags']);
            $content = strip_tags($row['content']);
            $excerpt = strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
            $image = resolveImagePath($row['image'], $row['date_posted'] ?? $row['created_at']);
          ?>
          <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="<?= $image ?>" class="card-img-top" alt="<?= $title ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $title ?></h5>
                <p class="text-muted small">By <?= $author ?> | <?= $date ?></p>
                <p class="card-text"><?= $excerpt ?></p>
                <a href="news-details.php?slug=<?= $slug ?>" class="btn btn-primary btn-sm">Read More</a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
              <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Prev</a></li>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
              <li class="page-item <?= ($p === $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $p ?>&search=<?= urlencode($search) ?>"><?= $p ?></a>
              </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
              <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a></li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="bg-white sidebar-box-shadow px-4 py-4">
          <!-- Search -->
          <div class="mb-4">
            <h4>Search News</h4>
            <form method="get" action="news.php">
              <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Type to search..." />
            </form>
          </div>

          <!-- Categories -->
          <div class="mb-4">
            <h4>Categories</h4>
            <ul class="list-unstyled">
              <?php
              $tags_result = $conn->query("SELECT tags FROM news WHERE status='published'");
              $all_tags = [];
              while ($t = $tags_result->fetch_assoc()) {
                  $tagList = explode(',', $t['tags']);
                  foreach ($tagList as $tag) {
                      $cleaned = trim($tag);
                      if (!in_array($cleaned, $all_tags) && $cleaned !== '') {
                          $all_tags[] = $cleaned;
                      }
                  }
              }
              sort($all_tags);
              foreach ($all_tags as $tag) {
                  echo '<li><a href="?search=' . urlencode($tag) . '">' . htmlspecialchars($tag) . '</a></li>';
              }
              ?>
            </ul>
          </div>

          <!-- Recent News -->
          <div class="mb-4">
            <h4>Recent News</h4>
            <?php
            $recentRes = $conn->query("SELECT title, slug, image, date_posted, created_at FROM news WHERE status='published' ORDER BY created_at DESC LIMIT 5");
            while ($r = $recentRes->fetch_assoc()):
              $r_title = htmlspecialchars($r['title']);
              $r_slug = urlencode($r['slug']);
              $r_img = resolveImagePath($r['image'], $r['date_posted'] ?? $r['created_at']);
            ?>
            <div class="d-flex mb-3">
              <div class="flex-shrink-0">
                <a href="news-details.php?slug=<?= $r_slug ?>">
                  <img src="<?= $r_img ?>" alt="<?= $r_title ?>" style="width: 80px; height: 60px; object-fit: cover;" class="rounded shadow-sm">
                </a>
              </div>
              <div class="ms-3">
                <a href="news-details.php?slug=<?= $r_slug ?>" class="text-dark fw-semibold"><?= $r_title ?></a>
              </div>
            </div>
            <?php endwhile; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
</body>
</html>
