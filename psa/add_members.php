<?php
// add-member.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/db.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $employer = trim($_POST['employer'] ?? '');
    $expertise = trim($_POST['expertise'] ?? '');
    $contacts = trim($_POST['contacts'] ?? '');

    // Validate required fields
    if ($name === '' || $qualification === '' || $employer === '' || $expertise === '' || $contacts === '') {
        $error = "Please fill in all required fields.";
    } else {
        // Handle optional image upload
        $image_name = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file_type = mime_content_type($_FILES['image']['tmp_name']);
                if (!in_array($file_type, $allowed_types)) {
                    $error = "Only JPG, PNG, and GIF images are allowed.";
                } else {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $image_name = uniqid('member_', true) . '.' . $ext;
                    $upload_dir = __DIR__ . '/uploads/members/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $upload_path = $upload_dir . $image_name;
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $error = "Failed to upload image.";
                    }
                }
            } else {
                $error = "Error uploading image.";
            }
        }

        if (!$error) {
            // Insert member into database
            $stmt = $conn->prepare("INSERT INTO psa_members (name, qualification, employer, expertise, contacts, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $qualification, $employer, $expertise, $contacts, $image_name);
            if ($stmt->execute()) {
                $message = "Member added successfully.";
                // Clear form data after success
                $name = $qualification = $employer = $expertise = $contacts = '';
                $image_name = null;
            } else {
                $error = "Database error: " . $stmt->error;
                // Delete uploaded image if DB insert fails
                if ($image_name && file_exists($upload_path)) unlink($upload_path);
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Member</title>
<link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
<style>
.container { max-width: 600px; margin-top: 40px; }
</style>
</head>
<body>
<div class="container">
    <h1>Add Member</h1>
    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= htmlspecialchars($name ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="qualification">Qualification <span class="text-danger">*</span></label>
            <input type="text" name="qualification" id="qualification" class="form-control" required value="<?= htmlspecialchars($qualification ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="employer">Employer/Occupation <span class="text-danger">*</span></label>
            <input type="text" name="employer" id="employer" class="form-control" required value="<?= htmlspecialchars($employer ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="expertise">Expertise <span class="text-danger">*</span></label>
            <textarea name="expertise" id="expertise" rows="3" class="form-control" required><?= htmlspecialchars($expertise ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="contacts">Contacts <span class="text-danger">*</span></label>
            <textarea name="contacts" id="contacts" rows="2" class="form-control" required><?= htmlspecialchars($contacts ?? '') ?></textarea>
            <small class="form-text text-muted">Include phone numbers, emails, etc.</small>
        </div>
        <div class="form-group">
            <label for="image">Image (optional, JPG/PNG/GIF)</label>
            <input type="file" name="image" id="image" accept="image/*" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Add Member</button>
    </form>
    <br>
    <a href="manage_members.php">Manage Members</a>
</div>

<script src="plugins/bootstrap/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
