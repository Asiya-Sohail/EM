<?php
require 'db.php';

// Check if survey_id is provided
if (!isset($_GET['survey_id']) || empty($_GET['survey_id'])) {
    die("❌ Invalid survey selection.");
}

$survey_id = $_GET['survey_id'];
$table_name = "lime_s_" . intval($survey_id); // Prevent SQL injection by forcing integer

// Check if table exists
$query_check = "SHOW TABLES LIKE :table_name";
$stmt_check = $pdo->prepare($query_check);
$stmt_check->execute([':table_name' => $table_name]);

if ($stmt_check->rowCount() == 0) {
    die("❌ Table $table_name does not exist! Check the survey ID.");
}

// Fetch survey data from `lime_s_[sid]`
$query = "SELECT * FROM $table_name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$survey_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If no data found
if (!$survey_data) {
    die("⚠ No data found in table $table_name.");
}

// Get column names dynamically
$columns = array_keys($survey_data[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Details - <?= htmlspecialchars($table_name) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="mb-4">Survey Details: <?= htmlspecialchars($table_name) ?></h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($survey_data as $row): ?>
                <tr>
                    <?php foreach ($columns as $col): ?>
                        <td><?= htmlspecialchars($row[$col]) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Selection</a>
</body>
</html>
