<?php
// edit-member.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid member ID.");
}

$member_id = intval($_GET['id']);
$error = '';
$success = '';

// Fetch member details
$stmt = $conn->prepare("SELECT * FROM psa_members WHERE id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("Member not found.");
$member = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $qualification = trim($_POST['qualification']);
    $employer = trim($_POST['employer']);
    $expertise = trim($_POST['expertise']);
    $contacts = trim($_POST['contacts']);

    // Handle optional image upload
    $image = $member['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/members/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid("member_") . "." . strtolower($ext);
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Delete old image if it exists
            if ($image && file_exists($upload_dir . $image)) {
                unlink($upload_dir . $image);
            }
            $image = $new_filename;
        } else {
            $error = "Failed to upload new image.";
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("UPDATE psa_members SET name=?, qualification=?, employer=?, expertise=?, contacts=?, image=? WHERE id=?");
        $stmt->bind_param("ssssssi", $name, $qualification, $employer, $expertise, $contacts, $image, $member_id);
        if ($stmt->execute()) {
            $success = "Member updated successfully!";
            // Refresh the updated values
            $member['name'] = $name;
            $member['qualification'] = $qualification;
            $member['employer'] = $employer;
            $member['expertise'] = $expertise;
            $member['contacts'] = $contacts;
            $member['image'] = $image;
        } else {
            $error = "Update failed.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Member</title>
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Member</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($member['name']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Qualification</label>
            <input type="text" name="qualification" value="<?= htmlspecialchars($member['qualification']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Employer / Occupation</label>
            <input type="text" name="employer" value="<?= htmlspecialchars($member['employer']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Area of Expertise</label>
            <input type="text" name="expertise" value="<?= htmlspecialchars($member['expertise']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Contacts (phone, email, etc)</label>
            <textarea name="contacts" rows="3" class="form-control"><?= htmlspecialchars($member['contacts']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Current Image</label><br>
            <?php if ($member['image'] && file_exists("uploads/members/" . $member['image'])): ?>
                <img src="uploads/members/<?= htmlspecialchars($member['image']) ?>" width="100" class="mb-2">
            <?php else: ?>
                <p><i>No image uploaded</i></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="manage_members.php" class="btn btn-secondary">Back to List</a>
    </form>
</div>

<script src="plugins/bootstrap/bootstrap.min.js"></script>
</body>
</html>
