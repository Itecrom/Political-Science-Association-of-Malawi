<?php
include 'includes/header.php';
include 'includes/db.php';
include 'includes/meta.php';

$categories = ['Patron', 'Members of the Executive', 'Editorial Team', 'Secretariate'];
$members = [];

foreach ($categories as $cat) {
  $stmt = $conn->prepare("SELECT * FROM team_members WHERE category = ? ORDER BY id ASC");
  $stmt->bind_param("s", $cat);
  $stmt->execute();
  $members[$cat] = $stmt->get_result();
}
?>

<!-- Bootstrap Styles (if not already included) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.team-section {
  padding: 60px 0;
}

.team-category-title {
  font-size: 26px;
  font-weight: bold;
  color: #117733;
  margin-bottom: 30px;
  text-align: center;
  position: relative;
}

.team-category-title::after {
  content: '';
  display: block;
  width: 80px;
  height: 3px;
  background: #117733;
  margin: 10px auto 0;
}

.team-card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  transition: transform 0.3s;
  text-align: center;
  padding: 25px 15px;
}

.team-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

.team-card img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
}

.team-card h5 {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin-bottom: 5px;
}

.team-card small {
  display: block;
  color: #117733;
  margin-bottom: 10px;
  font-weight: 500;
}

.team-card .social a {
  margin: 0 6px;
  color: #555;
  font-size: 15px;
  transition: color 0.3s;
}

.team-card .social a:hover {
  color: #117733;
}
</style>

<!-- Page Title -->
<section class="page-title overlay" style="background-image: url(images/background/page-title-2.jpg);">
  <div class="container text-center">
    <h2 class="text-white font-weight-bold">Meet the PSA Team</h2>
  </div>
</section>

<!-- Team Layout -->
<section class="team-section">
  <div class="container">

<?php foreach ($members as $category => $group): ?>
  <div class="team-category mb-5">
    <h3 class="team-category-title"><?= htmlspecialchars($category) ?></h3>
    <div class="row justify-content-center"> <!-- Centered cards -->
      <?php while ($m = $group->fetch_assoc()): ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="team-card">
            <img src="uploads/team/<?= htmlspecialchars($m['image']) ?>" alt="<?= htmlspecialchars($m['name']) ?>">
            <h5><?= htmlspecialchars($m['name']) ?></h5>
            <small><?= htmlspecialchars($m['position']) ?></small>
            <div class="social mt-2">
              <?php if ($m['facebook']): ?><a href="<?= $m['facebook'] ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
              <?php if ($m['twitter']): ?><a href="<?= $m['twitter'] ?>" target="_blank"><i class="fab fa-twitter"></i></a><?php endif; ?>
              <?php if ($m['linkedin']): ?><a href="<?= $m['linkedin'] ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
              <?php if ($m['google']): ?><a href="<?= $m['google'] ?>" target="_blank"><i class="fab fa-google"></i></a><?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
<?php endforeach; ?>


  </div>
</section>

<?php include 'includes/footer.php'; ?>
