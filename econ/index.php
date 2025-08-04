<?php
require 'db.php';

// Fetch all survey IDs and titles from new table `lime_s`
$query = "SELECT sid, s_title FROM lime_s ORDER BY s_title ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$surveys = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Analysis</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function updateSelectedSurvey() {
            let dropdown = document.getElementById("survey");
            let selectedSid = dropdown.value;
            let selectedText = dropdown.options[dropdown.selectedIndex].text;
            let message = selectedSid ? `Survey Selected - ${selectedSid}` : "No survey selected";
            document.getElementById("selectedSurveyMessage").innerText = message;
        }
    </script>
</head>
<body class="container mt-5">
    <h2 class="mb-4">Select a Survey</h2>
    <form action="results.php" method="GET">
        <div class="mb-3">
            <label for="survey" class="form-label">Choose a Survey:</label>
            <select name="survey_id" id="survey" class="form-select" required onchange="updateSelectedSurvey()">
                <option value="">-- Select a Survey --</option>
                <?php foreach ($surveys as $survey): ?>
                    <option value="<?= htmlspecialchars($survey['sid']) ?>">
                        <?= htmlspecialchars($survey['sid']) . " - " . htmlspecialchars($survey['s_title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <p id="selectedSurveyMessage" class="fw-bold text-primary">No survey selected</p>
        <button type="submit" class="btn btn-primary">View Survey Details</button>
    </form>
</body>
</html>


