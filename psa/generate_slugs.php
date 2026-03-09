<?php
include 'includes/db.php';

function generateSlug($title) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    return $slug;
}

$result = $conn->query("SELECT id, title FROM news WHERE slug IS NULL OR slug = ''");

while ($row = $result->fetch_assoc()) {
    $slug = generateSlug($row['title']);

    // Ensure slug is unique by appending ID if necessary
    $check = $conn->query("SELECT id FROM news WHERE slug = '$slug' AND id != {$row['id']}");
    if ($check->num_rows > 0) {
        $slug .= '-' . $row['id'];
    }

    $conn->query("UPDATE news SET slug = '$slug' WHERE id = {$row['id']}");
    echo "Slug set for ID {$row['id']}: $slug<br>";
}

echo "<br>✅ Slug generation complete.";
?>
