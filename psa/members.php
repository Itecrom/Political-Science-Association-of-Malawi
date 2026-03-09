<?php
// members.php
include 'includes/db.php';
include 'includes/header.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$where = "";
$params = [];
$param_types = "";

if ($search !== '') {
    $where = "WHERE name LIKE ? OR qualification LIKE ? OR employer LIKE ? OR expertise LIKE ? OR contacts LIKE ?";
    $like_search = "%$search%";
    $params = [$like_search, $like_search, $like_search, $like_search, $like_search];
    $param_types = "sssss";
}

// Count total
$count_sql = "SELECT COUNT(*) FROM psa_members $where";
$stmt = $conn->prepare($count_sql);
if ($where !== "") $stmt->bind_param($param_types, ...$params);
$stmt->execute();
$stmt->bind_result($total_members);
$stmt->fetch();
$stmt->close();

$total_pages = ceil($total_members / $limit);

// Fetch members
$sql = "SELECT * FROM psa_members $where ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($where === "") {
    $stmt->bind_param("ii", $limit, $offset);
} else {
    $param_types .= "ii";
    $params[] = $limit;
    $params[] = $offset;
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PSA Members</title>
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <style>
    .search-bar {
      max-width: 500px;
      margin: 30px auto;
    }
    .member-card {
      border: 1px solid #eee;
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .member-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .member-card img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ddd;
    }
    .member-info h5 {
      margin-bottom: 5px;
      font-weight: 600;
    }
    .pagination {
      justify-content: center;
    }
    body {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>

<section class="page-title overlay" style="background-image: url(images/background/page-title.jpg); padding: 60px 0;">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center text-white">
        <h2 class="font-weight-bold">PSA Members</h2>
      </div>
    </div>
  </div>
</section>

<section class="container mt-4">
  <form method="GET" class="search-bar">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Search by name, qualification, employer, etc." value="<?= htmlspecialchars($search) ?>">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </div>
  </form>

  <?php if ($result->num_rows > 0): ?>
    <div class="row">
      <?php while ($member = $result->fetch_assoc()): ?>
        <div class="col-md-6 mb-4">
          <div class="member-card">
            <img src="<?= $member['image'] && file_exists('uploads/members/' . $member['image']) ? 'uploads/members/' . htmlspecialchars($member['image']) : 'images/default-user.png' ?>" alt="<?= htmlspecialchars($member['name']) ?>">
            <div class="member-info">
              <h5><?= htmlspecialchars($member['name']) ?></h5>
              <p><strong>Qualification:</strong> <?= htmlspecialchars($member['qualification']) ?></p>
              <p><strong>Employer:</strong> <?= htmlspecialchars($member['employer']) ?></p>
              <p><strong>Expertise:</strong> <?= htmlspecialchars($member['expertise']) ?></p>
              <p><strong>Contacts:</strong> <?= nl2br(htmlspecialchars($member['contacts'])) ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
      <ul class="pagination">
        <?php if ($page > 1): ?>
          <li class="page-item"><a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>">Prev</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
          <li class="page-item"><a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>">Next</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php else: ?>
    <div class="alert alert-warning text-center mt-4">No members found.</div>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>

<?php
$stmt->close();
$conn->close();
?>
</body>
</html>
