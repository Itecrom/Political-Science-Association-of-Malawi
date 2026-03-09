<?php
include 'includes/db.php';
$search = trim($_GET['search'] ?? '');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=members_export.xls");

echo "Name\tQualification\tEmployer\tExpertise\tContacts\n";

if ($search) {
    $search_like = '%' . $conn->real_escape_string($search) . '%';
    $sql = $conn->prepare("SELECT name, qualification, employer, expertise, contacts FROM members 
        WHERE name LIKE ? OR qualification LIKE ? OR employer LIKE ? OR expertise LIKE ? OR contacts LIKE ?");
    $sql->bind_param("sssss", $search_like, $search_like, $search_like, $search_like, $search_like);
} else {
    $sql = $conn->prepare("SELECT name, qualification, employer, expertise, contacts FROM members");
}

$sql->execute();
$res = $sql->get_result();

while ($row = $res->fetch_assoc()) {
    echo "{$row['name']}\t{$row['qualification']}\t{$row['employer']}\t{$row['expertise']}\t{$row['contacts']}\n";
}
?>
