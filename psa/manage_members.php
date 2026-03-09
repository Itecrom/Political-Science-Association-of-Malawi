<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: auth/login.php");
include 'includes/db.php';

// Search and Pagination
$search = trim($_GET['search'] ?? '');
$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// Delete logic
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("SELECT image FROM psa_members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($img);
    if ($stmt->fetch() && $img && file_exists("uploads/members/$img")) unlink("uploads/members/$img");
    $stmt->close();
    $conn->query("DELETE FROM psa_members WHERE id = $id");
    header("Location: manage_members.php");
    exit;
}

// Build WHERE clause
$where = "";
$params = [];
$types = "";
if ($search !== '') {
    $where = "WHERE name LIKE ? OR qualification LIKE ? OR employer LIKE ? OR expertise LIKE ? OR contacts LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q, $q, $q];
    $types = "sssss";
}

// Count total for pagination
$count_sql = "SELECT COUNT(*) FROM psa_members $where";
$stmt = $conn->prepare($count_sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();
$total_pages = ceil($total / $limit);

// Fetch data
$sql = "SELECT id, name, qualification, employer, expertise, contacts, image FROM psa_members $where ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if ($params) {
    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;
    $stmt->bind_param($types, ...$params);
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
  <title>Manage PSA Members</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-red-700 via-black to-green-700 text-white p-6 space-y-4">
    <h2 class="text-2xl font-bold mb-4 text-center">PSA Admin</h2>
    <nav class="flex flex-col text-sm space-y-2">
      <a href="dashboard.php" class="hover:bg-white/10 p-2 rounded">🏠 Dashboard</a>
      <a href="manage_news.php" class="hover:bg-white/10 p-2 rounded">📰 Manage News</a>
      <a href="add_news.php" class="hover:bg-white/10 p-2 rounded">➕ Add News</a>
      <a href="manage_team.php" class="hover:bg-white/10 p-2 rounded">👥 Manage Team</a>
      <a href="manage_journals.php" class="hover:bg-white/10 p-2 rounded">📘 Journals</a>
      <a href="manage_members.php" class="bg-white/10 p-2 rounded font-bold">🧾 PSA Members</a>
      <a href="manage_users.php" class="hover:bg-white/10 p-2 rounded">🧑‍💼 Users</a>
      <a href="manage_subscribers.php" class="hover:bg-white/10 p-2 rounded">📩 Subscribers</a>
      <a href="auth/logout.php" class="hover:bg-red-600 bg-red-500 mt-4 p-2 rounded text-white">🚪 Logout</a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="flex-1 p-6">
    <h1 class="text-2xl font-bold text-green-700 mb-4">🧾 Manage PSA Members</h1>

    <!-- Search & Actions -->
    <form method="get" class="flex flex-wrap gap-2 mb-4">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or field..."
             class="border border-gray-300 px-3 py-2 rounded w-full sm:w-auto flex-1">
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Search</button>
      <a href="add_members.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➕ Add Member</a>
      <a href="export_members.php" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">⬇ Export</a>
    </form>

    <!-- Table -->
    <div class="overflow-auto bg-white shadow rounded">
      <table class="w-full text-sm text-left">
        <thead class="bg-green-800 text-white">
          <tr>
            <th class="p-3">Image</th>
            <th class="p-3">Name</th>
            <th class="p-3">Qualification</th>
            <th class="p-3">Employer</th>
            <th class="p-3">Expertise</th>
            <th class="p-3">Contacts</th>
            <th class="p-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows == 0): ?>
          <tr><td colspan="7" class="text-center p-4">No members found.</td></tr>
        <?php else: while ($row = $result->fetch_assoc()): ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="p-3">
              <?php if ($row['image'] && file_exists("uploads/members/" . $row['image'])): ?>
                <img src="uploads/members/<?= htmlspecialchars($row['image']) ?>" class="w-12 h-12 rounded-full object-cover">
              <?php else: ?>
                <img src="images/no-photo.png" class="w-12 h-12 rounded-full object-cover">
              <?php endif; ?>
            </td>
            <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['qualification']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['employer']) ?></td>
            <td class="p-3"><?= htmlspecialchars($row['expertise']) ?></td>
            <td class="p-3"><?= nl2br(htmlspecialchars($row['contacts'])) ?></td>
            <td class="p-3 text-center space-x-2">
              <a href="edit_members.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
              <a href="?delete=<?= $row['id'] ?>" class="text-red-600 hover:text-red-800"
                 onclick="return confirm('Are you sure you want to delete this member?')"><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        <?php endwhile; endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="mt-4 flex justify-center space-x-1">
      <?php for ($p = 1; $p <= $total_pages; $p++): ?>
        <a href="?search=<?= urlencode($search) ?>&page=<?= $p ?>"
           class="px-3 py-1 border rounded <?= $p == $page ? 'bg-green-600 text-white' : 'bg-white text-black' ?>">
           <?= $p ?>
        </a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>
  </main>
</div>

</body>
</html>
